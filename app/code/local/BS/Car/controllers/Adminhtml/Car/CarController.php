<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car admin controller
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Adminhtml_Car_CarController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the car
     *
     * @access protected
     * @return BS_Car_Model_Car
     */
    protected function _initCar()
    {
        $carId  = (int) $this->getRequest()->getParam('id');
        $car    = Mage::getModel('bs_car/car');
        if ($carId) {
            $car->load($carId);
        }
        Mage::register('current_car', $car);
        return $car;
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
        $this->_title(Mage::helper('bs_car')->__('Car'))
             ->_title(Mage::helper('bs_car')->__('Cars'));
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
     * edit car - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $carId    = $this->getRequest()->getParam('id');
        $car      = $this->_initCar();
        if ($carId && !$car->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_car')->__('This car no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCarData(true);
        if (!empty($data)) {
            $car->setData($data);
        }
        Mage::register('car_data', $car);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_car')->__('Car'))
             ->_title(Mage::helper('bs_car')->__('Cars'));
        if ($car->getId()) {
            $this->_title($car->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_car')->__('Add car'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new car action
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
     * save car - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('car')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'due_date' ,'close_date', 'res_date']);
                $car = $this->_initCar();

                $car->addData($data);


                $carSourceName = $this->_uploadAndGetName(
                    'car_source',
                    Mage::helper('bs_car/car')->getFileBaseDir(),
                    $data
                );
                $car->setData('car_source', $carSourceName);
                $remarkName = $this->_uploadAndGetName(
                    'remark',
                    Mage::helper('bs_car/car')->getFileBaseDir(),
                    $data
                );
                $car->setData('remark', $remarkName);
                $car->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$car->getRefType()."','car',".$car->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_car')->__('Car was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
	            $this->_redirect('*/*/edit', ['id' => $car->getId()]);
	            return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['car_source']['value'])) {
                    $data['car_source'] = $data['car_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCarData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['car_source']['value'])) {
                    $data['car_source'] = $data['car_source']['value'];
                }
                if (isset($data['remark']['value'])) {
                    $data['remark'] = $data['remark']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was a problem saving the car.')
                );
                Mage::getSingleton('adminhtml/session')->setCarData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_car')->__('Unable to find car to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete car - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $car = Mage::getModel('bs_car/car');
                $car->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_car')->__('Car was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error deleting car.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_car')->__('Could not find car to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete car - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars to delete.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                    $car = Mage::getModel('bs_car/car');
                    $car->setId($carId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_car')->__('Total of %d cars were successfully deleted.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error deleting cars.')
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
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                $car = Mage::getSingleton('bs_car/car')->load($carId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cars were successfully updated.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error updating cars.')
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
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                $car = Mage::getSingleton('bs_car/car')->load($carId)
                    ->setQrType($this->getRequest()->getParam('flag_qr_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cars were successfully updated.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error updating cars.')
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
    public function massCarStatusAction()
    {
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                $car = Mage::getSingleton('bs_car/car')->load($carId)
                    ->setCarStatus($this->getRequest()->getParam('flag_car_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cars were successfully updated.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error updating cars.')
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
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                $car = Mage::getSingleton('bs_car/car')->load($carId)
                    ->setAccept($this->getRequest()->getParam('flag_accept'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cars were successfully updated.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error updating cars.')
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
        $carIds = $this->getRequest()->getParam('car');
        if (!is_array($carIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_car')->__('Please select cars.')
            );
        } else {
            try {
                foreach ($carIds as $carId) {
                $car = Mage::getSingleton('bs_car/car')->load($carId)
                    ->setIsSubmitted($this->getRequest()->getParam('flag_is_submitted'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cars were successfully updated.', count($carIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_car')->__('There was an error updating cars.')
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
        $fileName   = 'car.csv';
        $content    = $this->getLayout()->createBlock('bs_car/adminhtml_car_grid')
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
        $fileName   = 'car.xls';
        $content    = $this->getLayout()->createBlock('bs_car/adminhtml_car_grid')
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
        $fileName   = 'car.xml';
        $content    = $this->getLayout()->createBlock('bs_car/adminhtml_car_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function generateCarAction()
    {

        if ($id = $this->getRequest()->getParam('id')) {
            $car = Mage::getSingleton('bs_car/car')->load($id);

            $this->generateCar($car);

        }
        $this->_redirect(
            '*/car_car/edit',
            [
                'id' => $this->getRequest()->getParam('id'),
                '_current' => true
            ]
        );

    }

    public function generateCar($obj)
    {
        $template = Mage::helper('bs_formtemplate')->getFormtemplate('2033');

        $fileName = $obj->getRefNo() . '_2033 CAR'.microtime();

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
        $checkbox = [];
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
                'code' => 'ref',
                'type'  => 'inline',
                'content' => $obj->getAuditReportRef()
            ],
            [
                'code' => 'description',
                'content' => $obj->getDescription()
            ],
            [
                'code' => 'root',
                'content' => $obj->getRootCause()
            ],

            [
                'code' => 'corrective',
                'content' => $obj->getCorrectiveAction()
            ],
            [
                'code' => 'follow_up',
                //'type'  => 'inline',
                'content' => $obj->getFollowUp()
            ],
        ];

        $reportDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getReportDate());
        $eventDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getEventDate());
        $dueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getDueDate());

        $data = [
            'no' => $obj->getCarNo(),
            'date' => $reportDate,
            'expire' => $dueDate,
            'sendto'    => $toName,
            'auditor' => $raisedBy,
            'auditee' => '',
            //'ref' => '',
            'level' => $obj->getLevel(),
            'nc' => $obj->getNcCauseText(),
            //'ac_type' => $acType,
            //'ac_reg' => $acReg,
            //'subject_other' => $subjectOther,
            //'cons_other' => $consOther,
            //'report_by' => $raisedBy,
            //'accept_by' => $approvalName,
            //'description' => $desc,
            //'analysis' => '',
            //'cause' => '',
            //'corrective' => '',


        ];

        /*$signatureManager = Mage::getModel('bs_signature/signature')->getCollection()
            ->addFieldToFilter('user_id', $obj->getApprovalId())
            ->setOrder('updated_at', 'DESC')
        ;
        $managerSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureManager->getFirstItem()->getSignature();*/


        $signatureInspector = Mage::getModel('bs_signature/signature')->getCollection()
            ->addFieldToFilter('user_id', $obj->getInsId())
            ->setOrder('updated_at', 'DESC')
        ;

        $auditorSign = Mage::helper('bs_signature/signature')->getFileBaseDir().$signatureInspector->getFirstItem()->getSignature();

        $images = [
            //'manager_sign' => $managerSign,
            'auditor_sign' => $auditorSign
        ];



        try {
            $res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, null,$checkbox,null,null,null,$htmlVariables,null, null, $images);
            $this->_getSession()->addSuccess(
                Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
            );


        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
    }

    public function massGenerateCarAction()
    {

        $cars = (array)$this->getRequest()->getParam('car');
        try {
            foreach ($cars as $carId) {
                $car = Mage::getSingleton('bs_car/car')
                    //->setStoreId($storeId)
                    ->load($carId);

                $this->generateCar($car);

            }

        } catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException(
                $e,
                Mage::helper('bs_car')->__('An error occurred while generating the files.')
            );
        }
        $this->_redirect('*/*/');
    }


    public function coasAction()
    {
        $this->_initCar();
        $this->loadLayout();
        $this->getLayout()->getBlock('car.edit.tab.coa');
        $this->renderLayout();
    }

    public function coasGridAction()
    {
        $this->_initCar();
        $this->loadLayout();
        $this->getLayout()->getBlock('car.edit.tab.coa');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/car');
    }
}
