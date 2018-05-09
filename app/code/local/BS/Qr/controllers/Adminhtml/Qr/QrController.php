<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR admin controller
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Adminhtml_Qr_QrController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the qr
     *
     * @access protected
     * @return BS_Qr_Model_Qr
     */
    protected function _initQr()
    {
        $qrId  = (int) $this->getRequest()->getParam('id');
        $qr    = Mage::getModel('bs_qr/qr');
        if ($qrId) {
            $qr->load($qrId);
        }
        Mage::register('current_qr', $qr);
        return $qr;
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
        $this->_title(Mage::helper('bs_qr')->__('QR'))
             ->_title(Mage::helper('bs_qr')->__('QR'));
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
     * edit qr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $qrId    = $this->getRequest()->getParam('id');
        $qr      = $this->_initQr();
        if ($qrId && !$qr->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_qr')->__('This qr no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getQrData(true);
        if (!empty($data)) {
            $qr->setData($data);
        }
        Mage::register('qr_data', $qr);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_qr')->__('QR'))
             ->_title(Mage::helper('bs_qr')->__('QR'));
        if ($qr->getId()) {
            $this->_title($qr->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_qr')->__('Add qr'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new qr action
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
     * save qr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('qr')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'due_date' ,'close_date']);
                $qr = $this->_initQr();

                $qr->addData($data);

                $qrSourceName = $this->_uploadAndGetName(
                    'qr_source',
                    Mage::helper('bs_qr/qr')->getFileBaseDir(),
                    $data
                );
                $qr->setData('qr_source', $qrSourceName);
                $remarkName = $this->_uploadAndGetName(
                    'remark',
                    Mage::helper('bs_qr/qr')->getFileBaseDir(),
                    $data
                );
                $qr->setData('remark', $remarkName);
                $qr->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$qr->getRefType()."','qr',".$qr->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qr')->__('QR was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', ['id' => $qr->getId()]);
	            return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['qr_source']['value'])) {
                    $data['qr_source'] = $data['qr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setQrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['qr_source']['value'])) {
                    $data['qr_source'] = $data['qr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was a problem saving the qr.')
                );
                Mage::getSingleton('adminhtml/session')->setQrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_qr')->__('Unable to find qr to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete qr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $qr = Mage::getModel('bs_qr/qr');
                $qr->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qr')->__('QR was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error deleting qr.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_qr')->__('Could not find qr to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete qr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr to delete.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                    $qr = Mage::getModel('bs_qr/qr');
                    $qr->setId($qrId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_qr')->__('Total of %d qr were successfully deleted.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error deleting qr.')
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
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                $qr = Mage::getSingleton('bs_qr/qr')->load($qrId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qr were successfully updated.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error updating qr.')
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
    public function massQrTypeAction()
    {
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                $qr = Mage::getSingleton('bs_qr/qr')->load($qrId)
                    ->setQrType($this->getRequest()->getParam('flag_qr_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qr were successfully updated.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error updating qr.')
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
    public function massQrStatusAction()
    {
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                $qr = Mage::getSingleton('bs_qr/qr')->load($qrId)
                    ->setQrStatus($this->getRequest()->getParam('flag_qr_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qr were successfully updated.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error updating qr.')
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
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                $qr = Mage::getSingleton('bs_qr/qr')->load($qrId)
                    ->setAccept($this->getRequest()->getParam('flag_accept'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qr were successfully updated.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error updating qr.')
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
        $qrIds = $this->getRequest()->getParam('qr');
        if (!is_array($qrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_qr')->__('Please select qr.')
            );
        } else {
            try {
                foreach ($qrIds as $qrId) {
                $qr = Mage::getSingleton('bs_qr/qr')->load($qrId)
                    ->setIsSubmitted($this->getRequest()->getParam('flag_is_submitted'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qr were successfully updated.', count($qrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_qr')->__('There was an error updating qr.')
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
        $fileName   = 'qr.csv';
        $content    = $this->getLayout()->createBlock('bs_qr/adminhtml_qr_grid')
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
        $fileName   = 'qr.xls';
        $content    = $this->getLayout()->createBlock('bs_qr/adminhtml_qr_grid')
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
        $fileName   = 'qr.xml';
        $content    = $this->getLayout()->createBlock('bs_qr/adminhtml_qr_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function generateQrAction()
	{

		if ($id = $this->getRequest()->getParam('id')) {
			$obj = Mage::getSingleton('bs_qr/qr')->load($id);

			$this->generateQr($obj);

		}
		$this->_redirect(
			'*/qr_qr/edit',
			[
				'id' => $this->getRequest()->getParam('id'),
				'_current' => true
            ]
		);

	}

	public function generateQr($obj)
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


		$tableWordML = [
			'isarray'  => true,
			'array'   => [
				'subject'   => $subjectML,
				'content' => $contentML,
				'remark' => $remarkML,
            ]
        ];

		$htmlVariables = [
			[
				'code' => 'subject',
				'content' => $obj->getSubject()
            ],
			[
				'code' => 'content',
				'content' => $obj->getContent()
            ],
			[
				'code' => 'remark',
				'content' => $obj->getRemarkText()
            ],

        ];

		$reportDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getReportDate());
		$closeDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getCloseDate());
		$dueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getDueDate());

		$data = [
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


        ];

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

		$images = [
			'manager_sign' => $managerSign,
			'inspector_sign' => $inspectorSign
        ];



		try {
			$res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, null,null,null,null,null,$htmlVariables,null,null,$images);
			$this->_getSession()->addSuccess(
				Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
			);


		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
	}

	public function massGenerateQrAction()
	{

		$objs = (array)$this->getRequest()->getParam('qr');
		try {
			foreach ($objs as $objId) {
				$obj = Mage::getSingleton('bs_qr/qr')
					//->setStoreId($storeId)
					       ->load($objId);

				$this->generateQr($obj);

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

    public function coasAction()
    {
        $this->_initQr();
        $this->loadLayout();
        $this->getLayout()->getBlock('qr.edit.tab.coa');
        $this->renderLayout();
    }

    public function coasGridAction()
    {
        $this->_initQr();
        $this->loadLayout();
        $this->getLayout()->getBlock('qr.edit.tab.coa');
        $this->renderLayout();
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/qr');
    }
}
