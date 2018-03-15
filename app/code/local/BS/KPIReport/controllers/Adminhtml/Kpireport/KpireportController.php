<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report admin controller
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Adminhtml_Kpireport_KpireportController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the kpi report
     *
     * @access protected
     * @return BS_KPIReport_Model_Kpireport
     */
    protected function _initKpireport()
    {
        $kpireportId  = (int) $this->getRequest()->getParam('id');
        $kpireport    = Mage::getModel('bs_kpireport/kpireport');
        if ($kpireportId) {
            $kpireport->load($kpireportId);
        }
        Mage::register('current_kpireport', $kpireport);
        return $kpireport;
    }

	public function reportAction()
	{
		$filter = $this->getRequest()->getParam('filter');
		$additional = $this->getRequest()->getParam('dograph');
		$requestData = Mage::helper('adminhtml')->prepareFilterString($filter);
		//$requestData = $this->_filterDates($requestData, array('from', 'to'));

		//$check = Mage::helper('bs_report')->checkReport($requestData['month'], $requestData['year']);


		//clear all current records
		/*$report = Mage::getModel('bs_report/qchaneff')->getCollection();
		$report->addFieldToFilter('month', $requestData['month']);
		$report->addFieldToFilter('year', $requestData['year']);
		if($report->count()){
			$report->walk('delete');
		}*/

		//get all qc staff
		/*$staff = Mage::getModel('bs_hr/staff')->getCollection();
		$staff->addFieldToFilter('room', 1);
		$staff->addFieldToFilter('region', 1);*/

		/*$qcHanUsers = Mage::getResourceModel('admin/roles_user_collection')
			->addFieldToFilter('role_id', array('in' => array(3,7)))
			->addFieldToFilter('is_active', 1)
		;*/


		//$this->_getSession()->addError(Mage::helper('bs_report')->__('There is no report OR you dont have permission to view!'));


		$redirect = array('filter' => $filter);
		$redirect['chart'] = '1';

		$this->_redirect('*/*/', $redirect);
	}

    public function updateAction()
    {

        try {
            $filter = $this->getRequest()->getParam('filter');
            $requestData = Mage::helper('adminhtml')->prepareFilterString($filter);

            $reportType = $requestData['report_type'];
            if($reportType == 1){//individual
                $depts = [$requestData['dept_single']];
                $indexes = explode(",", $requestData['index_multiple'][0]);
            }else {//multi
                $depts = explode(",", $requestData['dept_multiple'][0]);
                $indexes = [$requestData['index_single']];
            }

            $between = Mage::helper('bs_report')->getMonthYearBetween($requestData['from_month'], $requestData['from_year'], $requestData['to_month'], $requestData['to_year']);

            if(count($indexes) && $indexes[0] != ""){
                if(count($depts) && $depts[0] != ""){
                    foreach ($depts as $dept) {
                        foreach ($between as $item) {
                            Mage::helper('bs_kpireport')->updateData($indexes, $dept, $item[0], $item[1]);

                        }
                    }
                    $this->_getSession()->addSuccess(Mage::helper('bs_kpireport')->__('The data has been updated!'));
                }else {
                    $this->_getSession()->addError(Mage::helper('bs_kpireport')->__('Please select departments!'));
                }



            }else {
                $this->_getSession()->addError(Mage::helper('bs_kpireport')->__('Please select report indexes!'));
            }




            //$this->_getSession()->addError(Mage::helper('bs_kpireport')->__('Please select report indexes!'));

        }catch (Exception $e){
            $this->_getSession()->addError($e->getMessage());
        }


        $redirect = array('filter' => $filter);
        $this->_redirect('*/*/', $redirect);
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
        $this->_title(Mage::helper('bs_kpireport')->__('KPI Report'))
             ->_title(Mage::helper('bs_kpireport')->__('KPI Reports'));
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
     * edit kpi report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $kpireportId    = $this->getRequest()->getParam('id');
        $kpireport      = $this->_initKpireport();
        if ($kpireportId && !$kpireport->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_kpireport')->__('This kpi report no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getKpireportData(true);
        if (!empty($data)) {
            $kpireport->setData($data);
        }
        Mage::register('kpireport_data', $kpireport);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_kpireport')->__('KPI Report'))
             ->_title(Mage::helper('bs_kpireport')->__('KPI Reports'));
        if ($kpireport->getId()) {
            $this->_title($kpireport->getDeptId());
        } else {
            $this->_title(Mage::helper('bs_kpireport')->__('Add kpi report'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new kpi report action
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
     * save kpi report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('kpireport')) {
            try {
                $kpireport = $this->_initKpireport();
                $kpireport->addData($data);
                $kpireport->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpireport')->__('KPI Report was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $kpireport->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setKpireportData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpireport')->__('There was a problem saving the kpi report.')
                );
                Mage::getSingleton('adminhtml/session')->setKpireportData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_kpireport')->__('Unable to find kpi report to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete kpi report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $kpireport = Mage::getModel('bs_kpireport/kpireport');
                $kpireport->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpireport')->__('KPI Report was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpireport')->__('There was an error deleting kpi report.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_kpireport')->__('Could not find kpi report to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete kpi report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $kpireportIds = $this->getRequest()->getParam('kpireport');
        if (!is_array($kpireportIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_kpireport')->__('Please select kpi reports to delete.')
            );
        } else {
            try {
                foreach ($kpireportIds as $kpireportId) {
                    $kpireport = Mage::getModel('bs_kpireport/kpireport');
                    $kpireport->setId($kpireportId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpireport')->__('Total of %d kpi reports were successfully deleted.', count($kpireportIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpireport')->__('There was an error deleting kpi reports.')
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
        $kpireportIds = $this->getRequest()->getParam('kpireport');
        if (!is_array($kpireportIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_kpireport')->__('Please select kpi reports.')
            );
        } else {
            try {
                foreach ($kpireportIds as $kpireportId) {
                $kpireport = Mage::getSingleton('bs_kpireport/kpireport')->load($kpireportId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d kpi reports were successfully updated.', count($kpireportIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpireport')->__('There was an error updating kpi reports.')
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
        $fileName   = 'kpireport.csv';
        $content    = $this->getLayout()->createBlock('bs_kpireport/adminhtml_kpireport_grid')
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
        $fileName   = 'kpireport.xls';
        $content    = $this->getLayout()->createBlock('bs_kpireport/adminhtml_kpireport_grid')
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
        $fileName   = 'kpireport.xml';
        $content    = $this->getLayout()->createBlock('bs_kpireport/adminhtml_kpireport_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_report/kpireport');
    }
}
