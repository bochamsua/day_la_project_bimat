<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule admin controller
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Adminhtml_Schedule_ScheduleController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the schedule
     *
     * @access protected
     * @return BS_Schedule_Model_Schedule
     */
    protected function _initSchedule()
    {
        $scheduleId  = (int) $this->getRequest()->getParam('id');
        $schedule    = Mage::getModel('bs_schedule/schedule');
        if ($scheduleId) {
            $schedule->load($scheduleId);
        }
        Mage::register('current_schedule', $schedule);
        return $schedule;
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
        $this->_title(Mage::helper('bs_schedule')->__('QC HAN Schedule'))
             ->_title(Mage::helper('bs_schedule')->__('Schedule'));
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
     * edit schedule - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $scheduleId    = $this->getRequest()->getParam('id');
        $schedule      = $this->_initSchedule();
        if ($scheduleId && !$schedule->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_schedule')->__('This schedule no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getScheduleData(true);
        if (!empty($data)) {
            $schedule->setData($data);
        }
        Mage::register('schedule_data', $schedule);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_schedule')->__('QC HAN Schedule'))
             ->_title(Mage::helper('bs_schedule')->__('Schedule'));
        if ($schedule->getId()) {
            $this->_title($schedule->getName());
        } else {
            $this->_title(Mage::helper('bs_schedule')->__('Add schedule'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new schedule action
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
     * save schedule - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('schedule')) {
            try {
                $schedule = $this->_initSchedule();
                $schedule->addData($data);
                $schedule->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_schedule')->__('Schedule was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $schedule->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setScheduleData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_schedule')->__('There was a problem saving the schedule.')
                );
                Mage::getSingleton('adminhtml/session')->setScheduleData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_schedule')->__('Unable to find schedule to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete schedule - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $schedule = Mage::getModel('bs_schedule/schedule');
                $schedule->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_schedule')->__('Schedule was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_schedule')->__('There was an error deleting schedule.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_schedule')->__('Could not find schedule to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete schedule - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $scheduleIds = $this->getRequest()->getParam('schedule');
        if (!is_array($scheduleIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_schedule')->__('Please select schedule to delete.')
            );
        } else {
            try {
                foreach ($scheduleIds as $scheduleId) {
                    $schedule = Mage::getModel('bs_schedule/schedule');
                    $schedule->setId($scheduleId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_schedule')->__('Total of %d schedule were successfully deleted.', count($scheduleIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_schedule')->__('There was an error deleting schedule.')
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
        $scheduleIds = $this->getRequest()->getParam('schedule');
        if (!is_array($scheduleIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_schedule')->__('Please select schedule.')
            );
        } else {
            try {
                foreach ($scheduleIds as $scheduleId) {
                $schedule = Mage::getSingleton('bs_schedule/schedule')->load($scheduleId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d schedule were successfully updated.', count($scheduleIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_schedule')->__('There was an error updating schedule.')
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
        $fileName   = 'schedule.csv';
        $content    = $this->getLayout()->createBlock('bs_schedule/adminhtml_schedule_grid')
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
        $fileName   = 'schedule.xls';
        $content    = $this->getLayout()->createBlock('bs_schedule/adminhtml_schedule_grid')
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
        $fileName   = 'schedule.xml';
        $content    = $this->getLayout()->createBlock('bs_schedule/adminhtml_schedule_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_sched/schedule');
    }
}
