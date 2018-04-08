<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr admin controller
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Adminhtml_Ncr_NcrController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the ncr
     *
     * @access protected
     * @return BS_Ncr_Model_Ncr
     */
    protected function _initNcr()
    {
        $ncrId  = (int) $this->getRequest()->getParam('id');
        $ncr    = Mage::getModel('bs_ncr/ncr');
        if ($ncrId) {
            $ncr->load($ncrId);
        }
        Mage::register('current_ncr', $ncr);
        return $ncr;
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
        $this->_title(Mage::helper('bs_ncr')->__('Non-Conformity Report'))
             ->_title(Mage::helper('bs_ncr')->__('NCR'));
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
     * edit ncr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $ncrId    = $this->getRequest()->getParam('id');
        $ncr      = $this->_initNcr();
        if ($ncrId && !$ncr->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_ncr')->__('This ncr no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNcrData(true);
        if (!empty($data)) {
            $ncr->setData($data);
        }
        Mage::register('ncr_data', $ncr);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_ncr')->__('Non-Conformity Report'))
             ->_title(Mage::helper('bs_ncr')->__('NCR'));
        if ($ncr->getId()) {
            $this->_title($ncr->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_ncr')->__('Add ncr'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new ncr action
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
     * save ncr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('ncr')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'due_date' ,'close_date']);
                $ncr = $this->_initNcr();

	            $message = 'saved';


                $ncr->addData($data);

                $ncrSourceName = $this->_uploadAndGetName(
                    'ncr_source',
                    Mage::helper('bs_ncr/ncr')->getFileBaseDir(),
                    $data
                );
                $ncr->setData('ncr_source', $ncrSourceName);

	            $remarkName = $this->_uploadAndGetName(
                    'remark',
                    Mage::helper('bs_ncr/ncr')->getFileBaseDir(),
                    $data
                );
                $ncr->setData('remark', $remarkName);
                $ncr->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    //$add = '<script>window.opener.location.reload(); window.close()</script>';
                    $add = "<script>doPopup('".$ncr->getRefType()."','ncr',".$ncr->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncr')->__('Ncr was successfully %s. %s', $message, $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', ['id' => $ncr->getId()]);
	            return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['ncr_source']['value'])) {
                    $data['ncr_source'] = $data['ncr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNcrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['ncr_source']['value'])) {
                    $data['ncr_source'] = $data['ncr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was a problem saving the ncr.')
                );
                Mage::getSingleton('adminhtml/session')->setNcrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncr')->__('Unable to find ncr to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete ncr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {


                $ncr = Mage::getModel('bs_ncr/ncr');
                $ncr->setId($this->getRequest()->getParam('id'));
                //$this->doBeforeDeleteNrc($this->getRequest()->getParam('id'));
                $ncr->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncr')->__('Ncr was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error deleting ncr.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncr')->__('Could not find ncr to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * we need to do this before deleting ncrs
     *
     * @param array $ids
     *
     */
    public function doBeforeDeleteNrc($ncrId){

        $ncr = Mage::getSingleton('bs_ncr/ncr')->load($ncrId);
        $refType = $ncr->getRefType();
        $refId = $ncr->getRefId();

        $collection = Mage::getModel('bs_ncr/ncr')->getCollection();
        $collection->addFieldToFilter('ref_id', $refId);
        $collection->addFieldToFilter('ref_type', $refType);
        $collection->addFieldToFilter('entity_id', ['neq' => $ncr->getId()]);

        //if there is no ncr relates to this source, we need to update source to make ncre Ncr is set to No

        if(!$collection->count()){
            $model = 'bs_'.$refType.'/'.$refType;
            $parent = Mage::getModel($model)->load($refId);
            $parent->setData('ncr', 0)->save();
        }





    }

    /**
     * mass delete ncr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $ncrIds = $this->getRequest()->getParam('ncr');
        if (!is_array($ncrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncr')->__('Please select ncr to delete.')
            );
        } else {
            try {
                foreach ($ncrIds as $ncrId) {
                    $ncr = Mage::getModel('bs_ncr/ncr');
                    $ncr->setId($ncrId);
                    //$this->doBeforeDeleteNrc($ncrId);
                    $ncr->delete();
                }


                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncr')->__('Total of %d ncr were successfully deleted.', count($ncrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error deleting ncr.')
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
        $ncrIds = $this->getRequest()->getParam('ncr');
        if (!is_array($ncrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncr')->__('Please select ncr.')
            );
        } else {
            try {
                foreach ($ncrIds as $ncrId) {
                $ncr = Mage::getSingleton('bs_ncr/ncr')->load($ncrId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d ncr were successfully updated.', count($ncrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error updating ncr.')
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
    public function massNcrTypeAction()
    {
        $ncrIds = $this->getRequest()->getParam('ncr');
        if (!is_array($ncrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncr')->__('Please select ncr.')
            );
        } else {
            try {
                foreach ($ncrIds as $ncrId) {
                $ncr = Mage::getSingleton('bs_ncr/ncr')->load($ncrId)
                    ->setNcrType($this->getRequest()->getParam('flag_ncr_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d ncr were successfully updated.', count($ncrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error updating ncr.')
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
    public function massNcrStatusAction()
    {
        $ncrIds = $this->getRequest()->getParam('ncr');
        if (!is_array($ncrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncr')->__('Please select ncr.')
            );
        } else {
            try {
                foreach ($ncrIds as $ncrId) {
                $ncr = Mage::getSingleton('bs_ncr/ncr')->load($ncrId)
                    ->setNcrStatus($this->getRequest()->getParam('flag_ncr_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d ncr were successfully updated.', count($ncrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error updating ncr.')
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
        $ncrIds = $this->getRequest()->getParam('ncr');
        if (!is_array($ncrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncr')->__('Please select ncr.')
            );
        } else {
            try {
                foreach ($ncrIds as $ncrId) {
                $ncr = Mage::getSingleton('bs_ncr/ncr')->load($ncrId)
                    ->setAccept($this->getRequest()->getParam('flag_accept'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d ncr were successfully updated.', count($ncrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncr')->__('There was an error updating ncr.')
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
        $fileName   = 'ncr.csv';
        $content    = $this->getLayout()->createBlock('bs_ncr/adminhtml_ncr_grid')
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
        $fileName   = 'ncr.xls';
        $content    = $this->getLayout()->createBlock('bs_ncr/adminhtml_ncr_grid')
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
        $fileName   = 'ncr.xml';
        $content    = $this->getLayout()->createBlock('bs_ncr/adminhtml_ncr_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function updateDueDateAction(){
        $result = [];
        $typeId = $this->getRequest()->getPost('type_id');
        $fromDate = $this->getRequest()->getPost('from_date');

        $duedate = '';
        if($typeId && $fromDate){
            $interval = 0;
            switch ($typeId){
                case '1':
                    $interval = 7;
                    break;
                case '2':
                    $interval = 10;
                    break;
                case '3':
                    $interval = 13;
                    break;
                default:
                    $interval = 0;
            }

            $from = DateTime::createFromFormat('d/m/Y', $fromDate);
            $dateInterval = new DateInterval("P".$interval."D");
            $duedate = $from->add($dateInterval)->format("d/m/Y");
        }
        $result['duedate'] = $duedate;

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

	public function generateNcrAction()
	{

		if ($id = $this->getRequest()->getParam('id')) {
			$ncr = Mage::getSingleton('bs_ncr/ncr')->load($id);

			$this->generateNcr($ncr);

		}
		$this->_redirect(
			'*/ncr_ncr/edit',
			[
				'id' => $this->getRequest()->getParam('id'),
				'_current' => true
            ]
		);

	}

	public function generateNcr($ncr)
	{
		$template = Mage::helper('bs_formtemplate')->getFormtemplate('2029');

		$fileName = $ncr->getRefNo() . '_2029 Non-conformity report'.microtime();

		$to = Mage::getSingleton('bs_misc/department')->load($ncr->getDeptId());
		$toName = $to->getDeptName();

		$refDoc = $ncr->getRefDoc();

		$inspector = Mage::getModel('admin/user')->load($ncr->getInsId());
		$raisedBy = $inspector->getFirstname().' '.$inspector->getLastname();
		$raisedBy = Mage::helper('bs_docx')->toUppercase($raisedBy);


		$approval = Mage::getModel('admin/user')->load($ncr->getApprovalId());
		$approvalName = $approval->getFirstname().' '.$approval->getLastname();
		$approvalName = Mage::helper('bs_docx')->toUppercase($approvalName);


		$area = [];
		$acReg = Mage::getModel('bs_acreg/acreg')->load($ncr->getAcReg())->getReg();
		if($acReg != ''){
			$area[] = $acReg;
		}

		$locName = Mage::getModel('bs_misc/location')->load($ncr->getLocId())->getLocName();
		if($locName != ''){
			$area[] = $locName;
		}

		$area = implode(" - ", $area);



		$desc = $ncr->getDescription();
		$desc = explode("\r\n", $desc);
		$wordML = '';
		foreach ( $desc as $item ) {
			$wordML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}


		$signatureManager = Mage::getModel('bs_signature/signature')->getCollection()
		                         ->addFieldToFilter('user_id', $ncr->getApprovalId())
		                         ->setOrder('updated_at', 'DESC')
		;
		$managerSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureManager->getFirstItem()->getSignature();


		$signatureInspector = Mage::getModel('bs_signature/signature')->getCollection()
		                          ->addFieldToFilter('user_id', $ncr->getInsId())
		                          ->setOrder('updated_at', 'DESC')
		;

		$inspectorSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureInspector->getFirstItem()->getSignature();

		$images = [
			'manager_sign' => $managerSign,
			'inspector_sign' => $inspectorSign
        ];


		$tableWordML = [
			'isarray'  => true,
			'array'   => [
				'description'   => $wordML,

            ]
        ];

		$htmlVariables = [
			[
			'code' => 'description',
			'content'   => $ncr->getDescription()
            ]];

		$raisedDate = Mage::getModel('core/date')->date("d/m/Y", $ncr->getReportDate());
		$dueDate = Mage::getModel('core/date')->date("d/m/Y", $ncr->getDueDate());

		$data = [
			'ref' => $ncr->getRefNo(),
			'from' => 'QC HAN DIVISION',
			'to' => strtoupper($toName),
			'raised_by' => $raisedBy,
			'raised_date' => $raisedDate,
			'qc_manager' => $approvalName,
			'received_by' => '',
			'requirement_ref' => $refDoc,
			'affected_area' => $area,
			//'description' => $ncr->getDescription(),
			'level' => $ncr->getNcrType(),
			'due_date' => $dueDate,
			'root_cause' => '',
			'action' => '',
			'preventive' => '',
			'sign_date' => '',
			'comment' => '',
			'reviewed_by' => '',
			'close_date' => '',


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

	public function massGenerateNcrAction()
	{

		$ncrs = (array)$this->getRequest()->getParam('ncr');
		try {
			foreach ($ncrs as $ncrId) {
				$ncr = Mage::getSingleton('bs_ncr/ncr')
					//->setStoreId($storeId)
					        ->load($ncrId);

				$this->generateNcr($ncr);

			}

		} catch (Mage_Core_Model_Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		} catch (Mage_Core_Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		} catch (Exception $e) {
			$this->_getSession()->addException(
				$e,
				Mage::helper('bs_ncr')->__('An error occurred while generating the files.')
			);
		}
		$this->_redirect('*/*/', ['store' => $storeId]);
	}


    public function irsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initNcr();
        $this->loadLayout();
        $this->getLayout()->getBlock('ncr.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/ncr');
    }
}
