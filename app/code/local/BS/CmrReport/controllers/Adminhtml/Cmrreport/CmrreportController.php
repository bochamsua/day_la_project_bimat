<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report admin controller
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Adminhtml_Cmrreport_CmrreportController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the cmr report
     *
     * @access protected
     * @return BS_CmrReport_Model_Cmrreport
     */
    protected function _initCmrreport()
    {
        $cmrreportId  = (int) $this->getRequest()->getParam('id');
        $cmrreport    = Mage::getModel('bs_cmrreport/cmrreport');
        if ($cmrreportId) {
            $cmrreport->load($cmrreportId);
        }
        Mage::register('current_cmrreport', $cmrreport);
        return $cmrreport;
    }

    public function reportAction()
    {
        $filter = $this->getRequest()->getParam('filter');
        $additional = $this->getRequest()->getParam('dograph');
        $refresh = $this->getRequest()->getParam('refresh', false);
        $requestData = Mage::helper('adminhtml')->prepareFilterString($filter);
        //$requestData = $this->_filterDates($requestData, array('from', 'to'));


        $redirect = ['filter' => $filter];
        if($additional){
            $redirect['chart'] = '1';
        }

        $this->_redirect('*/*/', $redirect);
    }

    public function printAction()
    {
        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

        $month = $requestData['month'];
        $year = $requestData['year'];
        $customer = $requestData['customer'];

        if($customer > 0){
            $customerModel = Mage::getSingleton('bs_acreg/customer')->load($customer);
            $customerName = $customerModel->getName();
        }else {
            $customerName = 'All Customers';
        }

        $template = Mage::helper('bs_formtemplate')->getFormtemplate('cmr-report');

        $period = "{$month}- {$year} ({$customerName})";

        $fileName = 'CMR Report '.$period.microtime();


        $misc = Mage::helper('bs_misc');

        $data = [
            'period' => $period,
        ];

        $helper = Mage::helper('bs_cmrreport');

        $images = [];
        for($k=1; $k <= 4; $k++){
            ${'chart'.$k} = $helper->exportChart($month, $year, 6, $k, $customer);
            $images['chart'.$k] = ['image' => ${'chart'.$k}['file'],
                'options' => [
                    'float' => 'left',
                    'textWrap'  => 0,//inline
                    'width' => 368,
                    'height'    => 186,


                ]
            ];
        }








        $collection = $helper->getCmrData($month, $year, null, $customer);


        if($collection){
            $count = count($collection);

            for ($i = 1; $i <= 5; $i++){
                ${'group'.$i} = $helper->getGroupData($month, $year, $i, $count, $customer);
            }
        }

        // draw charts directly in Word, very professional but the result doesnt match the one on the web
        /*$charts = [];

        for($k=3; $k <= 4; $k++){
            ${'chart'.$k} = $helper->getPreviousCmrData($month, $year, 6, $k);
            ${'data'.$k} = [];
            foreach (${'chart'.$k} as $key => $value) {
                ${'data'.$k}[$key] = [$value];
            }

            $charts['chart'.$k] = [
                'data' => array_merge(['legend' => ['']], ${'data'.$k}),
                'type' => 'lineChart',
                'sizeX' => 13,
                'sizeY' => 7,
                'chartAlign' => 'center',
                'legendPos' => 'none',
                'hgrid' => 1,
                'smooth'    => false,
                'showValue' => true
            ];
        }*/





        $values = [
            ['', 'Số lượng (%)', 'Mã phát hiện', 'Mô tả', 'Nguyên nhân', 'Hành động khắc phục', 'Biện pháp phòng ngừa', 'Lặp lại'],
        ];


        for ($index =1; $index <= 5; $index++){

            if($index == 1){
                $text = 'Nhóm 1 (Sai lỗi bảo dưỡng)';
            }elseif($index == 2){
                $text = 'Nhóm 2 (Kế hoạch bảo dưỡng không đáp ứng)';
            }elseif($index == 3){
                $text = 'Nhóm 3 (Chương trình bảo dưỡng không đáp ứng)';
            }elseif($index == 4){
                $text = 'Nhóm 4 (Khuyến cáo không có cơ sở)';
            }else {
                $text = 'Nhóm 5 (Khác)';
            }
            $i=0;
            foreach (${'group'.$index}[0] as $item) {
                if($i == 0){
                    $values[] = [['rowspan' => (${'group'.$index}[1] > 0)?${'group'.$index}[1]:1, 'vAlign' => 'center', 'value' => $text], ['rowspan' => (${'group'.$index}[1] > 0)?${'group'.$index}[1]:1, 'vAlign' => 'center', 'value' => ${'group'.$index}[1]. " ({${'group'.$index}[2]} %)"], ($item)?$item->getCodeSqs():'', ($item)?$misc->handleTextForExport($item->getDescription()):'', ($item)?$misc->handleTextForExport($item->getRootCause()):'', ($item)?$misc->handleTextForExport($item->getCorrective()):'', ($item)?$misc->handleTextForExport($item->getPreventive()):'', ($item)?($item->getRepetitive())?'X':'':''];
                }else {
                    $values[] = [($item)?$item->getCodeSqs():'', ($item)?$misc->handleTextForExport($item->getDescription()):'', ($item)?$misc->handleTextForExport($item->getRootCause()):'', ($item)?$misc->handleTextForExport($item->getCorrective()):'', ($item)?$misc->handleTextForExport($item->getPreventive()):'', ($item->getRepetitive())?'X':''];
                }
                $i++;

            }
        }

        
        

        $tableComplex = [
            'table' => [
                'data'  => $values,
                'tproperties'   => [
                    /*'columnWidths' => ["10","5", "5", "30", "15", "15", "15", "5"],
                    'border' => 'single',
                    'borderWidth' => 4,
                    'borderColor' => 'cccccc',
                    'borderSettings' => 'inside',
                    'tableAlign' => 'left',
                    'float' => [
                        'align' => 'right',
                        'textMargin_top' => 300,
                        'textMargin_right' => 400,
                        'textMargin_bottom' => 300,
                        'textMargin_left' => 400
                    ],*/
                    'tableWidth' => [
                        'type' => 'pct',
                        'value' => 100
                    ],
                ],
                'rproperties'   => [0 => ['tableHeader' => true]]
            ],
            /*'table1' => [
                'data'  => [],
                'tproperties'   => [],
                'rproperties'   => []
            ]*/
        ];




        try {
            $res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, null, null, null, null, null, null, null, null, $images, null, $tableComplex);
            $this->_getSession()->addSuccess(
                Mage::helper('bs_cmrreport')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
            );


        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }


        $this->_redirect('*/*/', ['filter' => $this->getRequest()->getParam('filter')]);
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
        $this->_title(Mage::helper('bs_cmrreport')->__('CMR Report'))
             ->_title(Mage::helper('bs_cmrreport')->__('CMR Reports'));
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
     * edit cmr report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $cmrreportId    = $this->getRequest()->getParam('id');
        $cmrreport      = $this->_initCmrreport();
        if ($cmrreportId && !$cmrreport->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_cmrreport')->__('This cmr report no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCmrreportData(true);
        if (!empty($data)) {
            $cmrreport->setData($data);
        }
        Mage::register('cmrreport_data', $cmrreport);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_cmrreport')->__('CMR Report'))
             ->_title(Mage::helper('bs_cmrreport')->__('CMR Reports'));
        if ($cmrreport->getId()) {
            $this->_title($cmrreport->getName());
        } else {
            $this->_title(Mage::helper('bs_cmrreport')->__('Add cmr report'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cmr report action
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
     * save cmr report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('cmrreport')) {
            try {
                $cmrreport = $this->_initCmrreport();
                $cmrreport->addData($data);
                $cmrreport->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmrreport')->__('CMR Report was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $cmrreport->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCmrreportData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmrreport')->__('There was a problem saving the cmr report.')
                );
                Mage::getSingleton('adminhtml/session')->setCmrreportData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cmrreport')->__('Unable to find cmr report to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cmr report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $cmrreport = Mage::getModel('bs_cmrreport/cmrreport');
                $cmrreport->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmrreport')->__('CMR Report was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmrreport')->__('There was an error deleting cmr report.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cmrreport')->__('Could not find cmr report to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cmr report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $cmrreportIds = $this->getRequest()->getParam('cmrreport');
        if (!is_array($cmrreportIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmrreport')->__('Please select cmr reports to delete.')
            );
        } else {
            try {
                foreach ($cmrreportIds as $cmrreportId) {
                    $cmrreport = Mage::getModel('bs_cmrreport/cmrreport');
                    $cmrreport->setId($cmrreportId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmrreport')->__('Total of %d cmr reports were successfully deleted.', count($cmrreportIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmrreport')->__('There was an error deleting cmr reports.')
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
        $cmrreportIds = $this->getRequest()->getParam('cmrreport');
        if (!is_array($cmrreportIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmrreport')->__('Please select cmr reports.')
            );
        } else {
            try {
                foreach ($cmrreportIds as $cmrreportId) {
                $cmrreport = Mage::getSingleton('bs_cmrreport/cmrreport')->load($cmrreportId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr reports were successfully updated.', count($cmrreportIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmrreport')->__('There was an error updating cmr reports.')
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
        $fileName   = 'cmrreport.csv';
        $content    = $this->getLayout()->createBlock('bs_cmrreport/adminhtml_cmrreport_grid')
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
        $fileName   = 'cmrreport.xls';
        $content    = $this->getLayout()->createBlock('bs_cmrreport/adminhtml_cmrreport_grid')
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
        $fileName   = 'cmrreport.xml';
        $content    = $this->getLayout()->createBlock('bs_cmrreport/adminhtml_cmrreport_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_report/cmrreport');
    }
}
