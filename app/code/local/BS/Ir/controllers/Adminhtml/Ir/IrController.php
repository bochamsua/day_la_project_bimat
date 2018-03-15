<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir admin controller
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Adminhtml_Ir_IrController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the ir
     *
     * @access protected
     * @return BS_Ir_Model_Ir
     */
    protected function _initIr()
    {
        $irId  = (int) $this->getRequest()->getParam('id');
        $ir    = Mage::getModel('bs_ir/ir');
        if ($irId) {
            $ir->load($irId);
        }
        Mage::register('current_ir', $ir);
        return $ir;
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
        $this->_title(Mage::helper('bs_ir')->__('Ir'))
             ->_title(Mage::helper('bs_ir')->__('Irs'));
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
     * edit ir - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $irId    = $this->getRequest()->getParam('id');
        $ir      = $this->_initIr();
        if ($irId && !$ir->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_ir')->__('This ir no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getIrData(true);
        if (!empty($data)) {
            $ir->setData($data);
        }
        Mage::register('ir_data', $ir);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_ir')->__('Ir'))
             ->_title(Mage::helper('bs_ir')->__('Irs'));
        if ($ir->getId()) {
            $this->_title($ir->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_ir')->__('Add ir'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new ir action
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
     * save ir - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('ir')) {
            try {
                $data = $this->_filterDates($data, array('report_date', 'due_date',  'close_date', 'event_date'));
                $ir = $this->_initIr();

                $ir->addData($data);


	            $irSourceName = $this->_uploadAndGetName(
		            'ir_source',
		            Mage::helper('bs_ir/ir')->getFileBaseDir(),
		            $data
	            );
	            $ir->setData('ir_source', $irSourceName);

                $ir->save();

                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$ir->getRefType()."','ir',".$ir->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ir')->__('Ir was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', array('id' => $ir->getId()));
	            return;
            } catch (Mage_Core_Exception $e) {
	            if (isset($data['ir_source']['value'])) {
		            $data['ir_source'] = $data['ir_source']['value'];
	            }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setIrData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
	            if (isset($data['ir_source']['value'])) {
		            $data['ir_source'] = $data['ir_source']['value'];
	            }
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was a problem saving the ir.')
                );
                Mage::getSingleton('adminhtml/session')->setIrData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ir')->__('Unable to find ir to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete ir - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $ir = Mage::getModel('bs_ir/ir');
                $ir->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ir')->__('Ir was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error deleting ir.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ir')->__('Could not find ir to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete ir - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $irIds = $this->getRequest()->getParam('ir');
        if (!is_array($irIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ir')->__('Please select irs to delete.')
            );
        } else {
            try {
                foreach ($irIds as $irId) {
                    $ir = Mage::getModel('bs_ir/ir');
                    $ir->setId($irId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ir')->__('Total of %d irs were successfully deleted.', count($irIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error deleting irs.')
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
    public function massIrStatusAction()
    {
        $irIds = $this->getRequest()->getParam('ir');
        if (!is_array($irIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ir')->__('Please select irs.')
            );
        } else {
            try {
                foreach ($irIds as $irId) {
                $ir = Mage::getSingleton('bs_ir/ir')->load($irId)
                            ->setIrStatus($this->getRequest()->getParam('flag_ir_status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d irs were successfully updated.', count($irIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error updating irs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass NCR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massNcrAction()
    {
        $irIds = $this->getRequest()->getParam('ir');
        if (!is_array($irIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ir')->__('Please select irs.')
            );
        } else {
            try {
                foreach ($irIds as $irId) {
                $ir = Mage::getSingleton('bs_ir/ir')->load($irId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d irs were successfully updated.', count($irIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error updating irs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass QR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQrAction()
    {
        $irIds = $this->getRequest()->getParam('ir');
        if (!is_array($irIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ir')->__('Please select irs.')
            );
        } else {
            try {
                foreach ($irIds as $irId) {
                $ir = Mage::getSingleton('bs_ir/ir')->load($irId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d irs were successfully updated.', count($irIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error updating irs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass DRR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDrrAction()
    {
        $irIds = $this->getRequest()->getParam('ir');
        if (!is_array($irIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ir')->__('Please select irs.')
            );
        } else {
            try {
                foreach ($irIds as $irId) {
                $ir = Mage::getSingleton('bs_ir/ir')->load($irId)
                    ->setDrr($this->getRequest()->getParam('flag_drr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d irs were successfully updated.', count($irIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ir')->__('There was an error updating irs.')
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
        $fileName   = 'ir.csv';
        $content    = $this->getLayout()->createBlock('bs_ir/adminhtml_ir_grid')
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
        $fileName   = 'ir.xls';
        $content    = $this->getLayout()->createBlock('bs_ir/adminhtml_ir_grid')
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
        $fileName   = 'ir.xml';
        $content    = $this->getLayout()->createBlock('bs_ir/adminhtml_ir_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function generateIrAction()
	{

		if ($id = $this->getRequest()->getParam('id')) {
			$ir = Mage::getSingleton('bs_ir/ir')->load($id);

			$this->generateIr($ir);

		}
		$this->_redirect(
			'*/ir_ir/edit',
			array(
				'id' => $this->getRequest()->getParam('id'),
				'_current' => true
			)
		);

	}

	public function generateIr($obj)
	{
		$template = Mage::helper('bs_formtemplate')->getFormtemplate('2055');

		$fileName = $obj->getRefNo() . '_2055 Ir report'.microtime();

		$to = Mage::getSingleton('bs_misc/department')->load($obj->getDeptId());
		$toName = $to->getDeptName();

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

		$subjectOther = '';
		$subject = $obj->getSubject();
		$checkbox = array();
		if($subject == 1){
			$checkbox['maint_error'] = 1;
		}
		if($subject == 2){
			$checkbox['safety_event'] = 1;
		}
		if($subject == 3){
			$checkbox['accident'] = 1;
		}
		if($subject == 4){
			$checkbox['sub_other'] = 1;
			$subjectOther = $obj->getSubjectOther();
		}

		$consOther = '';
		$cons = $obj->getConsequence();
		if($cons == 1){
			$checkbox['aog'] = 1;
		}
		if($cons == 2){
			$checkbox['delay'] = 1;
		}
		if($cons == 3){
			$checkbox['injury'] = 1;
		}
		if($cons == 4){
			$checkbox['ac_damage'] = 1;
		}
		if($cons == 5){
			$checkbox['equipment_damage'] = 1;
		}
		if($cons == 6){
			$checkbox['cons_other_checkbox'] = 1;
			$consOther = $obj->getConsequenceOther();
		}


		/*$desc = $obj->getDescription();
		$desc = explode("\r\n", $desc);
		$descML = '';
		foreach ( $desc as $item ) {
			$descML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$analysis = $obj->getAnalysis();
		$analysis = explode("\r\n", $analysis);
		$analysisML = '';
		foreach ( $analysis as $item ) {
			$analysisML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$cause = $obj->getCauses();
		$cause = explode("\r\n", $cause);
		$causeML = '';
		foreach ( $cause as $item ) {
			$causeML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$corrective = $obj->getCorrective();
		$corrective = explode("\r\n", $corrective);
		$correctiveML = '';
		foreach ( $corrective as $item ) {
			$correctiveML .= '<w:p><w:r><w:rPr><w:rFonts w:ascii="Arial" w:eastAsia="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                                                </w:rPr>
                                        <w:t>'.$item.'</w:t></w:r></w:p>';
		}

		$tableWordML = array(
			'isarray'  => true,
			'array'   => array(
				'description'   => $descML,
				'analysis' => $analysisML,
				'cause' => $causeML,
				'corrective' => $correctiveML,
			)
		);*/

		$htmlVariables = array(
			array(
				'code' => 'description',
				'content' => $obj->getDescription()
			),
			array(
				'code' => 'analysis',
				'content' => $obj->getAnalysis()
			),
			array(
				'code' => 'cause',
				'content' => $obj->getCauses()
			),
			array(
				'code' => 'corrective',
				'content' => $obj->getCorrective()
			),
            array(
                'code' => 'cons_other',
                'type'  => 'inline',
                'content' => $consOther
            ),
            array(
                'code' => 'subject_other',
                'type'  => 'inline',
                'content' => $subjectOther
            ),
		);

		$reportDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getReportDate());
		$eventDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getEventDate());
		$dueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getDueDate());

		$data = array(
			'ref' => $obj->getRefNo(),
			'report_date' => $reportDate,
			'event_date'    => $eventDate,
			'loc' => $locName,
			'cause_code' => $causeCode,
			'ac_type' => $acType,
			'ac_reg' => $acReg,
			//'subject_other' => $subjectOther,
			//'cons_other' => $consOther,
			'report_by' => $raisedBy,
			'accept_by' => $approvalName,
			//'description' => $desc,
			//'analysis' => '',
			//'cause' => '',
			//'corrective' => '',


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
			$res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, null,$checkbox,null,null,null,$htmlVariables,null, null, $images);
			$this->_getSession()->addSuccess(
				Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
			);


		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
	}

	public function massGenerateIrAction()
	{

		$irs = (array)$this->getRequest()->getParam('ir');
		try {
			foreach ($irs as $irId) {
				$ir = Mage::getSingleton('bs_ir/ir')
					//->setStoreId($storeId)
					       ->load($irId);

				$this->generateIr($ir);

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

	public function ncrsAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.ncr');
		$this->renderLayout();
	}

	public function ncrsGridAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.ncr');
		$this->renderLayout();
	}

	public function qrsAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.qr');
		$this->renderLayout();
	}

	public function qrsGridAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.qr');
		$this->renderLayout();
	}

	public function drrsAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.drr');
		$this->renderLayout();
	}

	public function drrsGridAction()
	{
		$this->_initIr();
		$this->loadLayout();
		$this->getLayout()->getBlock('ir.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/ir');
    }
}
