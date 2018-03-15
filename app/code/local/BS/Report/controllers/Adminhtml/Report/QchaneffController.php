<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation admin controller
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Adminhtml_Report_QchaneffController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the qc han efficiency
     *
     * @access protected
     * @return BS_Report_Model_Qchaneff
     */
    protected function _initQchaneff()
    {
        $qchaneffId  = (int) $this->getRequest()->getParam('id');
        $qchaneff    = Mage::getModel('bs_report/qchaneff');
        if ($qchaneffId) {
            $qchaneff->load($qchaneffId);
        }
        Mage::register('current_qchaneff', $qchaneff);
        return $qchaneff;
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
        $this->_title(Mage::helper('bs_report')->__('Report'))
             ->_title(Mage::helper('bs_report')->__('QC HAN Evaluation'));
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
     * edit qc han efficiency - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $qchaneffId    = $this->getRequest()->getParam('id');
        $qchaneff      = $this->_initQchaneff();
        if ($qchaneffId && !$qchaneff->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_report')->__('This qc han efficiency no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getQchaneffData(true);
        if (!empty($data)) {
            $qchaneff->setData($data);
        }
        Mage::register('qchaneff_data', $qchaneff);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_report')->__('Report'))
             ->_title(Mage::helper('bs_report')->__('QC HAN Evaluation'));
        if ($qchaneff->getId()) {
            $this->_title($qchaneff->getName());
        } else {
            $this->_title(Mage::helper('bs_report')->__('Add qc han efficiency'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new qc han efficiency action
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
     * save qc han efficiency - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('qchaneff')) {
            try {
                $data = $this->_filterDates($data, array('from_date' ,'to_date'));
                $qchaneff = $this->_initQchaneff();
                $qchaneff->addData($data);
                $qchaneff->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('QC HAN Evaluation was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $qchaneff->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setQchaneffData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was a problem saving the qc han efficiency.')
                );
                Mage::getSingleton('adminhtml/session')->setQchaneffData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Unable to find qc han efficiency to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete qc han efficiency - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $qchaneff = Mage::getModel('bs_report/qchaneff');
                $qchaneff->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('QC HAN Evaluation was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting qc han efficiency.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Could not find qc han efficiency to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete qc han efficiency - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $qchaneffIds = $this->getRequest()->getParam('qchaneff');
        if (!is_array($qchaneffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select qc han efficiency to delete.')
            );
        } else {
            try {
                foreach ($qchaneffIds as $qchaneffId) {
                    $qchaneff = Mage::getModel('bs_report/qchaneff');
                    $qchaneff->setId($qchaneffId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Total of %d qc han efficiency were successfully deleted.', count($qchaneffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting qc han efficiency.')
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
        $qchaneffIds = $this->getRequest()->getParam('qchaneff');
        if (!is_array($qchaneffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select qc han efficiency.')
            );
        } else {
            try {
                foreach ($qchaneffIds as $qchaneffId) {
                $qchaneff = Mage::getSingleton('bs_report/qchaneff')->load($qchaneffId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qc han efficiency were successfully updated.', count($qchaneffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error updating qc han efficiency.')
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
        $fileName   = 'qchaneff.csv';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_qchaneff_grid')
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
        $fileName   = 'qchaneff.xls';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_qchaneff_grid')
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
        $fileName   = 'qchaneff.xml';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_qchaneff_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function reportAction()
	{
		$filter = $this->getRequest()->getParam('filter');
		$additional = $this->getRequest()->getParam('dograph');
		$refresh = $this->getRequest()->getParam('refresh', false);
		$requestData = Mage::helper('adminhtml')->prepareFilterString($filter);
		//$requestData = $this->_filterDates($requestData, array('from', 'to'));

		$check = Mage::helper('bs_report')->checkReport($requestData['month'], $requestData['year']);


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

		if(Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff/reset')){

		}
		if(!$check ){//we just init report if there is no existing one in db

			if(Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff/reset')){
				Mage::helper('bs_report')->initReport($requestData['month'], $requestData['year']);


				$this->_getSession()->addSuccess(Mage::helper('bs_report')->__('The report for %s-%s has been generated!', $requestData['month'], $requestData['year']));
			}else {
				$this->_getSession()->addError(Mage::helper('bs_report')->__('There is no report OR you dont have permission to view!'));
			}

		}

		if($refresh){
			Mage::helper('bs_report')->refreshReport($requestData['month'], $requestData['year']);


			$this->_getSession()->addSuccess(Mage::helper('bs_report')->__('The report for %s-%s has been refreshed!', $requestData['month'], $requestData['year']));
		}


		$redirect = array('filter' => $filter);
		if($additional){
			$redirect['chart'] = '1';
		}

		$this->_redirect('*/*/', $redirect);
	}

	public function printAction()
	{
		$requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
		//$requestData = $this->_filterDates($requestData, array('from', 'to'));

		//$result = Mage::helper('bs_report')->checkReport($requestData['month'], $requestData['year']);

		$month = $requestData['month'];
		$year = $requestData['year'];

		$template = Mage::helper('bs_formtemplate')->getFormtemplate('qcefficiency');

		$fileName = 'QC Work Efficiency '.$month.'-'.$year.microtime();


		$workdays = 22;
		$workday = Mage::getModel('bs_report/workday')->getCollection()
		               ->addFieldToFilter('month', $month)
		               ->addFieldToFilter('year', $year)
		;
		if($workday->getFirstItem()->getId()){
			$workdays = $workday->getFirstItem()->getDays();
		}

		$data = array(
			'month' => $month,
			'year'  => $year,
			'workdays'  => $workdays
		);

		//get all report
		$report = Mage::getModel('bs_report/qchaneff')->getCollection();
		$report->addFieldToFilter('month', $month);
		$report->addFieldToFilter('year', $year);

		$pointData = array();

		$i=1;
		foreach ( $report as $item ) {

			$user = Mage::getModel('admin/user')->load($item->getInsId());

			$vaecoId = $user->getVaecoId();

			$pointData[] = array(
				'i' => $i,
				'vaecoid' => $vaecoId,
				'name' => $user->getFirstname().' '.$user->getLastname(),
				'd1' => $item->getD1(),
				'd2' => $item->getD2(),
				'd3' => $item->getD3(),
				'd'   => $item->getDall(),
				'level' => 'Mức '.$item->getLevel()
			);

			$i ++;
		}

		$tableData = array($pointData);

		try {
			$res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data, $tableData);
			$this->_getSession()->addSuccess(
				Mage::helper('bs_report')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
			);


		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}

		
		$this->_redirect('*/*/', array('filter' => $this->getRequest()->getParam('filter')));
	}

	public function updateAction()
	{

		$filter = '';
		if($this->getRequest()->getPost('filter')){
			$filter = $this->getRequest()->getParam('filter');
			$requestData = Mage::helper('adminhtml')->prepareFilterString($filter);
		}else {

		}

		//$data = $this->getRequest()->getPost('data');
		$data = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('data'));
		foreach ($data as $key => $values) {
			$function = 'set'.ucfirst($key);
			foreach ( $values as $k => $v ) {
				$model = Mage::getModel('bs_report/qchaneff')->load($k);
				//make sure we remove remark because remark can be empty
				//so just set remark null first
				$model->setRemark('');
				$model->{$function}($v);

				//now we need to update other D and level
				$d1 = floatval($model->getD1());
				$d2 = floatval($model->getD2());
				$d3 = floatval($model->getD3());

				$dAll = 0.5 * $d1 + 0.3 * $d2 + 0.2 * $d3;
				$dAll = round($dAll, 2);

				$level = Mage::helper('bs_report')->getLevel($dAll);

				$model->setDall($dAll);
				$model->setLevel($level);

				$model->save();
			}

		}



		$result = array();
		$result['filter'] = $filter;

		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}

	public function resetAction()
	{
		$filter = $this->getRequest()->getParam('filter');
		$requestData = Mage::helper('adminhtml')->prepareFilterString($filter);
		//$requestData = $this->_filterDates($requestData, array('from', 'to'));

		//$check = Mage::helper('bs_report')->checkReport($requestData['month'], $requestData['year']);


		//clear all current records
		$report = Mage::getModel('bs_report/qchaneff')->getCollection();
		$report->addFieldToFilter('month', $requestData['month']);
		$report->addFieldToFilter('year', $requestData['year']);
		if($report->count()){
			$report->walk('delete');
		}

		Mage::helper('bs_report')->initReport($requestData['month'], $requestData['year']);


		$this->_getSession()->addSuccess(Mage::helper('bs_report')->__('The report for %s-%s has been reset!', $requestData['month'], $requestData['year']));


		$this->_redirect('*/*/', array('filter' => $filter));
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff');
    }
}
