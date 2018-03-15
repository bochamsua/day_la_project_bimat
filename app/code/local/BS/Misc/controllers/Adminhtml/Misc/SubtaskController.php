<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_SubtaskController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the sub task
     *
     * @access protected
     * @return BS_Misc_Model_Subtask
     */
    protected function _initSubtask()
    {
        $subtaskId  = (int) $this->getRequest()->getParam('id');
        $subtask    = Mage::getModel('bs_misc/subtask');
        if ($subtaskId) {
            $subtask->load($subtaskId);
        }
        Mage::register('current_subtask', $subtask);
        return $subtask;
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
             ->_title(Mage::helper('bs_misc')->__('Survey Sub Codes'));
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
     * edit sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $subtaskId    = $this->getRequest()->getParam('id');
        $subtask      = $this->_initSubtask();
        if ($subtaskId && !$subtask->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This sub task no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSubtaskData(true);
        if (!empty($data)) {
            $subtask->setData($data);
        }
        Mage::register('subtask_data', $subtask);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Survey Sub Codes'));
        if ($subtask->getId()) {
            $this->_title($subtask->getSubCode());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add sub task'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new sub task action
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
     * save sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('subtask')) {
            try {
                $subtask = $this->_initSubtask();
                if($data['import'] != ''){
                    $import = $data['import'];
                    $import = explode("\r\n", $import);
                    $taskId = $data['task_id'];
                    foreach ($import as $line) {
                        if(strpos($line, "--")){
                            $item = explode("--", $line);
                        }else {
                            $item = explode("\t", $line);
                        }



                        $count = count($item);
                        if($count > 1){
                            $code = trim($item[0]);
                            $desc = trim($item[1]);

                            $subtask    = Mage::getModel('bs_misc/subtask');
                            $subtask->setTaskId($taskId);
                            $subtask->setSubCode($code);
                            $subtask->setSubDesc($desc);
                            $subtask->save();
                        }



                    }

                }else {
                    $subtask->addData($data);
                    $subtask->save();
                }


                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Sub Task was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $subtask->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSubtaskData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the sub task.')
                );
                Mage::getSingleton('adminhtml/session')->setSubtaskData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find sub task to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $subtask = Mage::getModel('bs_misc/subtask');
                $subtask->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Sub Task was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting sub task.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find sub task to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $subtaskIds = $this->getRequest()->getParam('subtask');
        if (!is_array($subtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub tasks to delete.')
            );
        } else {
            try {
                foreach ($subtaskIds as $subtaskId) {
                    $subtask = Mage::getModel('bs_misc/subtask');
                    $subtask->setId($subtaskId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d sub tasks were successfully deleted.', count($subtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting sub tasks.')
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
        $subtaskIds = $this->getRequest()->getParam('subtask');
        if (!is_array($subtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub tasks.')
            );
        } else {
            try {
                foreach ($subtaskIds as $subtaskId) {
                $subtask = Mage::getSingleton('bs_misc/subtask')->load($subtaskId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sub tasks were successfully updated.', count($subtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating sub tasks.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass task change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massTaskIdAction()
    {
        $subtaskIds = $this->getRequest()->getParam('subtask');
        if (!is_array($subtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub tasks.')
            );
        } else {
            try {
                foreach ($subtaskIds as $subtaskId) {
                $subtask = Mage::getSingleton('bs_misc/subtask')->load($subtaskId)
                    ->setTaskId($this->getRequest()->getParam('flag_task_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sub tasks were successfully updated.', count($subtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating sub tasks.')
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
        $fileName   = 'subtask.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subtask_grid')
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
        $fileName   = 'subtask.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subtask_grid')
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
        $fileName   = 'subtask.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subtask_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/subtask');
    }
}
