<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr admin controller
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Adminhtml_Drr_DrrController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the drr
     *
     * @access protected
     * @return BS_Drr_Model_Drr
     */
    protected function _initDrr()
    {
        $drrId  = (int) $this->getRequest()->getParam('id');
        $drr    = Mage::getModel('bs_drr/drr');
        if ($drrId) {
            $drr->load($drrId);
        }
        Mage::register('current_drr', $drr);
        return $drr;
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
        $this->_title(Mage::helper('bs_drr')->__('Drr'))
             ->_title(Mage::helper('bs_drr')->__('Drrs'));
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
     * edit drr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $drrId    = $this->getRequest()->getParam('id');
        $drr      = $this->_initDrr();
        if ($drrId && !$drr->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_drr')->__('This drr no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getDrrData(true);
        if (!empty($data)) {
            $drr->setData($data);
        }
        Mage::register('drr_data', $drr);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_drr')->__('Drr'))
             ->_title(Mage::helper('bs_drr')->__('Drrs'));
        if ($drr->getId()) {
            $this->_title($drr->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_drr')->__('Add drr'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new drr action
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
     * save drr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('drr')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $drr = $this->_initDrr();


                $drr->addData($data);



                $drrSourceName = $this->_uploadAndGetName(
                    'drr_source',
                    Mage::helper('bs_drr/drr')->getFileBaseDir(),
                    $data
                );
                $drr->setData('drr_source', $drrSourceName);
                $remarkName = $this->_uploadAndGetName(
                    'remark',
                    Mage::helper('bs_drr/drr')->getFileBaseDir(),
                    $data
                );
                $drr->setData('remark', $remarkName);
                $drr->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$drr->getRefType()."','drr',".$drr->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_drr')->__('Drr was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', array('id' => $drr->getId()));
	            return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['drr_source']['value'])) {
                    $data['drr_source'] = $data['drr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setDrrData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['drr_source']['value'])) {
                    $data['drr_source'] = $data['drr_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was a problem saving the drr.')
                );
                Mage::getSingleton('adminhtml/session')->setDrrData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_drr')->__('Unable to find drr to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete drr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $drr = Mage::getModel('bs_drr/drr');
                $drr->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_drr')->__('Drr was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error deleting drr.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_drr')->__('Could not find drr to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete drr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs to delete.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                    $drr = Mage::getModel('bs_drr/drr');
                    $drr->setId($drrId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_drr')->__('Total of %d drrs were successfully deleted.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error deleting drrs.')
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
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')->load($drrId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d drrs were successfully updated.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error updating drrs.')
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
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')->load($drrId)
                    ->setQrType($this->getRequest()->getParam('flag_qr_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d drrs were successfully updated.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error updating drrs.')
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
    public function massDrrStatusAction()
    {
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')->load($drrId)
                    ->setDrrStatus($this->getRequest()->getParam('flag_drr_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d drrs were successfully updated.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error updating drrs.')
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
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')->load($drrId)
                    ->setAccept($this->getRequest()->getParam('flag_accept'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d drrs were successfully updated.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error updating drrs.')
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
        $drrIds = $this->getRequest()->getParam('drr');
        if (!is_array($drrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_drr')->__('Please select drrs.')
            );
        } else {
            try {
                foreach ($drrIds as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')->load($drrId)
                    ->setIsSubmitted($this->getRequest()->getParam('flag_is_submitted'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d drrs were successfully updated.', count($drrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_drr')->__('There was an error updating drrs.')
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
        $fileName   = 'drr.csv';
        $content    = $this->getLayout()->createBlock('bs_drr/adminhtml_drr_grid')
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
        $fileName   = 'drr.xls';
        $content    = $this->getLayout()->createBlock('bs_drr/adminhtml_drr_grid')
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
        $fileName   = 'drr.xml';
        $content    = $this->getLayout()->createBlock('bs_drr/adminhtml_drr_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function irsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initDrr();
        $this->loadLayout();
        $this->getLayout()->getBlock('drr.edit.tab.drr');
        $this->renderLayout();
    }


    public function generateDrrAction()
    {

        if ($id = $this->getRequest()->getParam('id')) {
            $drr = Mage::getSingleton('bs_drr/drr')->load($id);

            $this->generateDrr($drr);

        }
        $this->_redirect(
            '*/drr_drr/edit',
            array(
                'id' => $this->getRequest()->getParam('id'),
                '_current' => true
            )
        );

    }

    public function generateDrr($obj)
    {
        $template = Mage::helper('bs_formtemplate')->getFormtemplate('drr');

        $fileName = $obj->getRefNo() . '_2055 DRR'.microtime();


        $from = Mage::getModel('bs_sur/sur_attribute_source_section')->getOptionText($obj->getSection());
        $from .= ' '.Mage::getModel('bs_sur/sur_attribute_source_region')->getOptionText($obj->getRegion());

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

        $htmlVariables = [
            [
                'code' => 'description',
                //'type'  => 'inline',
                'content' => $obj->getDescription()
            ],

        ];

        $reportDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getReportDate());
        $eventDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getEventDate());
        $dueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getDueDate());

        $data = array(
            'ref' => $obj->getRefNo(),
            'report_date' => $reportDate,
            'due_date' => $dueDate,
            'from'    => $from,
            'to' => $toName,
            'flight_no' => $obj->getFlightNo(),
            //'ac_type' => $acType,
            'ac_reg' => $acReg,
            //'subject_other' => $subjectOther,
            //'cons_other' => $consOther,
            'raised_by' => $raisedBy,
            //'accept_by' => $approvalName,
            //'description' => $desc,
            //'analysis' => '',
            //'cause' => '',
            //'corrective' => '',


        );

        /*$signatureManager = Mage::getModel('bs_signature/signature')->getCollection()
            ->addFieldToFilter('user_id', $obj->getApprovalId())
            ->setOrder('updated_at', 'DESC')
        ;
        $managerSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureManager->getFirstItem()->getSignature();*/


        $signatureInspector = Mage::getModel('bs_signature/signature')->getCollection()
            ->addFieldToFilter('user_id', $obj->getInsId())
            ->setOrder('updated_at', 'DESC')
        ;

        $inspectorSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureInspector->getFirstItem()->getSignature();

        $images = array(
            //'manager_sign' => $managerSign,
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

    public function massGenerateDrrAction()
    {

        $drrs = (array)$this->getRequest()->getParam('drr');
        try {
            foreach ($drrs as $drrId) {
                $drr = Mage::getSingleton('bs_drr/drr')
                    //->setStoreId($storeId)
                    ->load($drrId);

                $this->generateDrr($drr);

            }

        } catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException(
                $e,
                Mage::helper('bs_drr')->__('An error occurred while generating the files.')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/drr');
    }
}
