<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Survey Group admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_TaskgroupController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the task code group
     *
     * @access protected
     * @return BS_Misc_Model_Taskgroup
     */
    protected function _initTaskgroup()
    {
        $taskgroupId  = (int) $this->getRequest()->getParam('id');
        $taskgroup    = Mage::getModel('bs_misc/taskgroup');
        if ($taskgroupId) {
            $taskgroup->load($taskgroupId);
        }
        Mage::register('current_taskgroup', $taskgroup);
        return $taskgroup;
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
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Survey Groups'));
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
     * edit task code group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $taskgroupId    = $this->getRequest()->getParam('id');
        $taskgroup      = $this->_initTaskgroup();
        if ($taskgroupId && !$taskgroup->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This task code group no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getTaskgroupData(true);
        if (!empty($data)) {
            $taskgroup->setData($data);
        }
        Mage::register('taskgroup_data', $taskgroup);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Survey Groups'));
        if ($taskgroup->getId()) {
            $this->_title($taskgroup->getGroupName());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add task code group'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new task code group action
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
     * save task code group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('taskgroup')) {
            try {
                $taskgroup = $this->_initTaskgroup();
                $taskgroup->addData($data);
                $taskgroup->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Survey Group was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $taskgroup->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTaskgroupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the task code group.')
                );
                Mage::getSingleton('adminhtml/session')->setTaskgroupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find task code group to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete task code group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $taskgroup = Mage::getModel('bs_misc/taskgroup');
                $taskgroup->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Survey Group was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting task code group.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find task code group to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete task code group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $taskgroupIds = $this->getRequest()->getParam('taskgroup');
        if (!is_array($taskgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select task code groups to delete.')
            );
        } else {
            try {
                foreach ($taskgroupIds as $taskgroupId) {
                    $taskgroup = Mage::getModel('bs_misc/taskgroup');
                    $taskgroup->setId($taskgroupId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d task code groups were successfully deleted.', count($taskgroupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting task code groups.')
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
        $taskgroupIds = $this->getRequest()->getParam('taskgroup');
        if (!is_array($taskgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select task code groups.')
            );
        } else {
            try {
                foreach ($taskgroupIds as $taskgroupId) {
                $taskgroup = Mage::getSingleton('bs_misc/taskgroup')->load($taskgroupId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d task code groups were successfully updated.', count($taskgroupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating task code groups.')
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
        $fileName   = 'taskgroup.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_taskgroup_grid')
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
        $fileName   = 'taskgroup.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_taskgroup_grid')
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
        $fileName   = 'taskgroup.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_taskgroup_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/taskgroup');
    }
}
