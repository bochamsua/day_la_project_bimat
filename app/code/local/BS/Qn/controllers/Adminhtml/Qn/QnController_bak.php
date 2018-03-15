<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN admin controller
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Adminhtml_Qn_QnController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the qn
     *
     * @access protected
     * @return BS_Qn_Model_Qn
     */
    protected function _initQn()
    {
        $qnId  = (int) $this->getRequest()->getParam('id');
        $qn    = Mage::getModel('bs_qn/qn');
        if ($qnId) {
            $qn->load($qnId);
        }
        Mage::register('current_qn', $qn);
        return $qn;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('bs_qn')->__('QN'))
             ->_title(Mage::helper('bs_qn')->__('QN'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit qn - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $qnId    = $this->getRequest()->getParam('id');
        $qn      = $this->_initQn();
        if ($qnId && !$qn->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_qn')->__('This qn no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getQnData(true);
        if (!empty($data)) {
            $qn->setData($data);
        }
        Mage::register('qn_data', $qn);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_qn')->__('QN'))
             ->_title(Mage::helper('bs_qn')->__('QN'));
        if ($qn->getId()) {
            $this->_title($qn->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_qn')->__('Add qn'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new qn action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save qn - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('qn')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $qn = $this->_initQn();

                $currentUser = Mage::helper('bs_misc')->getCurrentUserInfo();
                /*if(!$qn->getId()){
                    $data['ins_id'] = $currentUser[0];
                    $data['region'] = $currentUser[2];
                    $data['section'] = $currentUser[3];
                    //$data['ref_no'] = Mage::helper('bs_misc/relation')->getNextRefNo('ncr', $currentUser[2]);
                    $data['ref_no'] = Mage::helper('bs_qn')->getNextRefNo();
	                $data['qn_status'] = 0;
                }*/

	            $message = 'saved';

	            if( $qn->getId()){//$roleId == 3 &&, this will lead to direct input param exploit but it's fine for now

		            if($this->getRequest()->getParam('accept')){
			            $qn->setQnStatus(2);
			            $qn->setRejectReason('');
			            $qn->setApprovalId($currentUser[0]);
			            $message = 'accepted';
			            //$data['ncr_status'] = 2;
			            //$data['approval_id'] = $adminUserId;
			            $qn->save();

			            Mage::getSingleton('adminhtml/session')->addSuccess(
				            Mage::helper('adminhtml')->__('QN was successfully %s.', $message)
			            );

			            $this->_redirect('*/*/edit', array('id' => $qn->getId()));
			            return;
		            }elseif($this->getRequest()->getParam('reject')){
			            //$data['ncr_status'] = 0;
			            $qn->setQnStatus(0);
			            $qn->setRejectReason($data['reject_reason']);
			            $message = 'rejected';
			            $qn->save();

			            Mage::getSingleton('adminhtml/session')->addSuccess(
				            Mage::helper('adminhtml')->__('QN was successfully %s.', $message)
			            );

			            $this->_redirect('*/*/edit', array('id' => $qn->getId()));
			            return;
		            }elseif($this->getRequest()->getParam('close')){
			            //$data['ncr_status'] = 3;
			            $qn->addData($data);
			            $closeDate = Mage::getModel('core/date')->date("Y-m-d", now());
			            //$qn->setCloseDate($closeDate);
			            $qn->setQnStatus(3);
			            $ncrSourceName = $this->_uploadAndGetName(
				            'qn_source',
				            Mage::helper('bs_qn/qn')->getFileBaseDir(),
				            $data
			            );
			            $qn->setData('qn_source', $ncrSourceName);
			            $remarkName = $this->_uploadAndGetName(
				            'remark',
				            Mage::helper('bs_qn/qn')->getFileBaseDir(),
				            $data
			            );
			            $qn->setData('remark', $remarkName);
			            $message = 'closed';
			            $qn->save();

			            Mage::getSingleton('adminhtml/session')->addSuccess(
				            Mage::helper('adminhtml')->__('QN was successfully %s.', $message)
			            );

			            $this->_redirect('*/*/edit', array('id' => $qn->getId()));
			            return;
		            }elseif($this->getRequest()->getParam('submitted')){
			            $qn->setQnStatus(1);
			            $qnSourceName = $this->_uploadAndGetName(
				            'qn_source',
				            Mage::helper('bs_qn/qn')->getFileBaseDir(),
				            $data
			            );
			            $qn->setData('qn_source', $qnSourceName);
			            $remarkName = $this->_uploadAndGetName(
				            'remark',
				            Mage::helper('bs_qn/qn')->getFileBaseDir(),
				            $data
			            );
			            $qn->setData('remark', $remarkName);
			            $message = 'submitted';
			            $qn->save();

			            Mage::getSingleton('adminhtml/session')->addSuccess(
				            Mage::helper('adminhtml')->__('QN was successfully %s.', $message)
			            );

			            $this->_redirect('*/*/edit', array('id' => $qn->getId()));
			            return;
		            }




	            }

	            if($currentUser[1] == 3){ //directly accept
		            if($this->getRequest()->getParam('accept')){
			            $qn->setQnStatus(2);
			            $qn->setRejectReason('');
			            $qn->setApprovalId($currentUser[0]);
			            $message = 'accepted';
			            //$data['ncr_status'] = 2;
			            //$data['approval_id'] = $adminUserId;
		            }elseif($this->getRequest()->getParam('close')){
			            //$data['ncr_status'] = 3;
			            $closeDate = Mage::getModel('core/date')->date("Y-m-d", now());
			            //$qn->setCloseDate($closeDate);
			            $qn->setQnStatus(3);
			            $message = 'closed';
		            }
	            }


                $qn->addData($data);


                $qnSourceName = $this->_uploadAndGetName(
                    'qn_source',
                    Mage::helper('bs_qn/qn')->getFileBaseDir(),
                    $data
                );
                $qn->setData('qn_source', $qnSourceName);
                $remarkName = $this->_uploadAndGetName(
                    'remark',
                    Mage::helper('bs_qn/qn')->getFileBaseDir(),
                    $data
                );
                $qn->setData('remark', $remarkName);
                $qn->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$qn->getRefType()."','qn',".$qn->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qn')->__('QN was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', array('id' => $qn->getId()));
	            return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['qn_source']['value'])) {
                    $data['qn_source'] = $data['qn_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setQnData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['qn_source']['value'])) {
                    $data['qn_source'] = $data['qn_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was a problem saving the qn.')
                );
                Mage::getSingleton('adminhtml/session')->setQnData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_qn')->__('Unable to find qn to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete qn - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $qn = Mage::getModel('bs_qn/qn');
                $qn->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qn')->__('QN was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error deleting qn.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_qn')->__('Could not find qn to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete qn - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn to delete.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                    $qn = Mage::getModel('bs_qn/qn');
                    $qn->setId($qnId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qn')->__('Total of %d qn were successfully deleted.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error deleting qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massStatusAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                $qn = Mage::getSingleton('bs_qn/qn')->load($qnId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qn were successfully updated.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error updating qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Type change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQnTypeAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                $qn = Mage::getSingleton('bs_qn/qn')->load($qnId)
                    ->setQnType($this->getRequest()->getParam('flag_qn_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qn were successfully updated.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error updating qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Status change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQnStatusAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                $qn = Mage::getSingleton('bs_qn/qn')->load($qnId)
                    ->setQnStatus($this->getRequest()->getParam('flag_qn_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qn were successfully updated.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error updating qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Accept/Reject change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massAcceptAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                $qn = Mage::getSingleton('bs_qn/qn')->load($qnId)
                    ->setAccept($this->getRequest()->getParam('flag_accept'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qn were successfully updated.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error updating qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Is Submitted? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massIsSubmittedAction()
    {
        $qnIds = $this->getRequest()->getParam('qn');
        if (!is_array($qnIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qn')->__('Please select qn.')
            );
        } else {
            try {
                foreach ($qnIds as $qnId) {
                $qn = Mage::getSingleton('bs_qn/qn')->load($qnId)
                    ->setIsSubmitted($this->getRequest()->getParam('flag_is_submitted'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qn were successfully updated.', count($qnIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qn')->__('There was an error updating qn.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportCsvAction()
    {
        $fileName   = 'qn.csv';
        $content    = $this->getLayout()->createBlock('bs_qn/adminhtml_qn_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportExcelAction()
    {
        $fileName   = 'qn.xls';
        $content    = $this->getLayout()->createBlock('bs_qn/adminhtml_qn_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportXmlAction()
    {
        $fileName   = 'qn.xml';
        $content    = $this->getLayout()->createBlock('bs_qn/adminhtml_qn_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function generateQnAction()
	{

		if ($id = $this->getRequest()->getParam('id')) {
			$obj = Mage::getSingleton('bs_qn/qn')->load($id);

			$this->generateQn($obj);

		}
		$this->_redirect(
			'*/qn_qn/edit',
			array(
				'id' => $this->getRequest()->getParam('id'),
				'_current' => true
			)
		);

	}

	public function generateQn($obj)
	{
		$template = Mage::helper('bs_formtemplate')->getFormtemplate('2059');

		$fileName = $obj->getRefNo() . '_2059 Quality Request '.microtime();

		$sentTo = Mage::getSingleton('bs_misc/department')->load($obj->getDeptId());
		$sentToName = $sentTo->getDeptName();

		$cc = Mage::getSingleton('bs_misc/department')->load($obj->getDeptIdCc());
		$ccName = $cc->getDeptName();

		$refDoc = $obj->getRefDoc();

		$inspector = Mage::getModel('admin/user')->load($obj->getInsId());
		$raisedBy = $inspector->getFirstname().' '.$inspector->getLastname();
		$raisedBy = Mage::helper('bs_docx')->toUppercase($raisedBy);


		$approval = Mage::getModel('admin/user')->load($obj->getApprovalId());
		$approvalName = $approval->getFirstname().' '.$approval->getLastname();
		$approvalName = Mage::helper('bs_docx')->toUppercase($approvalName);


		$acType = Mage::getModel('bs_misc/aircraft')->load($obj->getAcType())->getAcCode();
		$acReg = Mage::getModel('bs_acreg/acreg')->load($obj->getAcReg())->getReg();

		$locName = Mage::getModel('bs_misc/location')->load($obj->getLocId())->getLocName();

		$causeCode = Mage::getSingleton('bs_ncause/ncause')->load($obj->getNcauseId())->getCauseCode();




		$subject = $obj->getSubject();
		$subject = explode("\r\n", $subject);
		$subjectML = '';
		foreach ( $subject as $item ) {
			$subjectML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$content = $obj->getContent();
		$content = explode("\r\n", $content);
		$contentML = '';
		foreach ( $content as $item ) {
			$contentML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$remark = $obj->getRemarkText();
		$remark = explode("\r\n", $remark);
		$remarkML = '';
		foreach ( $remark as $item ) {
			$remarkML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}


		$tableWordML = array(
			'isarray'  => true,
			'array'   => array(
				'subject'   => $subjectML,
				'content' => $contentML,
				'remark' => $remarkML,
			)
		);

		$htmlVariables = array(
			array(
				'code' => 'subject',
				'content' => $obj->getSubject()
			),
			array(
				'code' => 'content',
				'content' => $obj->getContent()
			),
			array(
				'code' => 'remark',
				'content' => $obj->getRemarkText()
			),

		);

		$reportDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getReportDate());
		$closeDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getCloseDate());
		$dueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getDueDate());

		$data = array(
			'ref' => $obj->getRefNo(),
			'date' => $reportDate,
			'request_by' => $approvalName,
			'sent_to' => $sentToName,
			'cc' => $ccName,
			//'subject' => '',
			//'content' => '',
			//'remark' => '',
			'completion_date' => $closeDate,
			'record' => '',
			'name' => '',
			'signature' => '',


		);

		$signatureManager = Mage::getModel('bs_signature/signature')->getCollection()
		                        ->addFieldToFilter('user_id', $obj->getApprovalId())
		                        ->setOrder('updated_at', 'DESC')
		;
		$managerSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureManager->getFirstItem()->getSignature();


		$signatureInspector = Mage::getModel('bs_signature/signature')->getCollection()
		                          ->addFieldToFilter('user_id', $obj->getInsId())
		                          ->setOrder('updated_at', 'DESC')
		;

		$inspectorSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureInspector->getFirstItem()->getSignature();

		$images = array(
			'manager_sign' => $managerSign,
			'inspector_sign' => $inspectorSign
		);



		try {
			$res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, null,null,null,null,null,$htmlVariables,null,null,$images);
			$this->_getSession()->addSuccess(
				Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
			);


		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
	}

	public function massGenerateQnAction()
	{

		$objs = (array)$this->getRequest()->getParam('qn');
		try {
			foreach ($objs as $objId) {
				$obj = Mage::getSingleton('bs_qn/qn')
					//->setStoreId($storeId)
					       ->load($objId);

				$this->generateQn($obj);

			}

		} catch (Mage_Core_Model_Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		} catch (Mage_Core_Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		} catch (Exception $e) {
			$this->_getSession()->addException(
				$e,
				Mage::helper('bs_ir')->__('An error occurred while generating the files.')
			);
		}
		$this->_redirect('*/*/');
	}

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Bui Phong
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/qn');
    }
}
