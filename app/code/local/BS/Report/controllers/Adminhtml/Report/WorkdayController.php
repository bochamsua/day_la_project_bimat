<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Work Day admin controller
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Adminhtml_Report_WorkdayController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the work day
     *
     * @access protected
     * @return BS_Report_Model_Workday
     */
    protected function _initWorkday()
    {
        $workdayId  = (int) $this->getRequest()->getParam('id');
        $workday    = Mage::getModel('bs_report/workday');
        if ($workdayId) {
            $workday->load($workdayId);
        }
        Mage::register('current_workday', $workday);
        return $workday;
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
             ->_title(Mage::helper('bs_report')->__('Work Days'));
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
     * edit work day - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $workdayId    = $this->getRequest()->getParam('id');
        $workday      = $this->_initWorkday();
        if ($workdayId && !$workday->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_report')->__('This work day no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getWorkdayData(true);
        if (!empty($data)) {
            $workday->setData($data);
        }
        Mage::register('workday_data', $workday);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_report')->__('Report'))
             ->_title(Mage::helper('bs_report')->__('Work Days'));
        if ($workday->getId()) {
            $this->_title($workday->getDays());
        } else {
            $this->_title(Mage::helper('bs_report')->__('Add work day'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new work day action
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
     * save work day - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('workday')) {
            try {
                $workday = $this->_initWorkday();
                $workday->addData($data);
                $workday->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Work Day was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $workday->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setWorkdayData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was a problem saving the work day.')
                );
                Mage::getSingleton('adminhtml/session')->setWorkdayData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Unable to find work day to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete work day - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $workday = Mage::getModel('bs_report/workday');
                $workday->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Work Day was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting work day.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Could not find work day to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete work day - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $workdayIds = $this->getRequest()->getParam('workday');
        if (!is_array($workdayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select work days to delete.')
            );
        } else {
            try {
                foreach ($workdayIds as $workdayId) {
                    $workday = Mage::getModel('bs_report/workday');
                    $workday->setId($workdayId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Total of %d work days were successfully deleted.', count($workdayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting work days.')
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
        $workdayIds = $this->getRequest()->getParam('workday');
        if (!is_array($workdayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select work days.')
            );
        } else {
            try {
                foreach ($workdayIds as $workdayId) {
                $workday = Mage::getSingleton('bs_report/workday')->load($workdayId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d work days were successfully updated.', count($workdayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error updating work days.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Month change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massMonthAction()
    {
        $workdayIds = $this->getRequest()->getParam('workday');
        if (!is_array($workdayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select work days.')
            );
        } else {
            try {
                foreach ($workdayIds as $workdayId) {
                $workday = Mage::getSingleton('bs_report/workday')->load($workdayId)
                    ->setMonth($this->getRequest()->getParam('flag_month'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d work days were successfully updated.', count($workdayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error updating work days.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Year change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massYearAction()
    {
        $workdayIds = $this->getRequest()->getParam('workday');
        if (!is_array($workdayIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select work days.')
            );
        } else {
            try {
                foreach ($workdayIds as $workdayId) {
                $workday = Mage::getSingleton('bs_report/workday')->load($workdayId)
                    ->setYear($this->getRequest()->getParam('flag_year'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d work days were successfully updated.', count($workdayIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error updating work days.')
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
        $fileName   = 'workday.csv';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_workday_grid')
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
        $fileName   = 'workday.xls';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_workday_grid')
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
        $fileName   = 'workday.xml';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_workday_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function generateWorkdayAction()
	{
		try {
			$requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
			//$requestData = $this->_filterDates($requestData, array('from', 'to'));

			$year = $requestData['year'];
			$check = Mage::helper('bs_report')->checkWorkday($year);
			if(!$check){

				for($i=1; $i <= 12; $i++){
					$j=$i;
					if($j < 10){
						$j = '0'.$j;
					}

					$start = $year.'-'.$j.'-01';
					$numDays = Mage::helper('bs_report')->getDaysInMonth($i, $year);
					$end = $year.'-'.$j.'-'.$numDays;

					$days = Mage::helper('bs_report')->getWorkingDays($start, $end);

					$wd = Mage::getModel('bs_report/workday');
					$wd->setMonth($i);
					$wd->setYear($year);
					$wd->setDays($days);
					$wd->save();
				}


				$this->_getSession()->addSuccess(Mage::helper('bs_report')->__('The work days for %s have been generated!', $year));

			}else {
				$this->_getSession()->addNotice(Mage::helper('bs_report')->__('The work days for %s have already been generated! Re-generating is not allowed.', $year));
			}
		}catch (Exception $e){
			$this->_getSession()->addError($e->getMessage());
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/workday');
    }
}
