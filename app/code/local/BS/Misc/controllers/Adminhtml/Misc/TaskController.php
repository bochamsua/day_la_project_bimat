<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Task admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_TaskController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the task
     *
     * @access protected
     * @return BS_Misc_Model_Task
     */
    protected function _initTask()
    {
        $taskId  = (int) $this->getRequest()->getParam('id');
        $task    = Mage::getModel('bs_misc/task');
        if ($taskId) {
            $task->load($taskId);
        }
        Mage::register('current_task', $task);
        return $task;
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
             ->_title(Mage::helper('bs_misc')->__('Survey Codes'));
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
     * edit task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $taskId    = $this->getRequest()->getParam('id');
        $task      = $this->_initTask();
        if ($taskId && !$task->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This task no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getTaskData(true);
        if (!empty($data)) {
            $task->setData($data);
        }
        Mage::register('task_data', $task);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Survey Codes'));
        if ($task->getId()) {
            $this->_title($task->getTaskCode());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add task'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new task action
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
     * save task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('task')) {
            try {
                $task = $this->_initTask();

                if($data['import'] != ''){
                    $import = $data['import'];
                    $import = explode("\r\n", $import);
                    $taskGroupId = $data['taskgroup_id'];
                    foreach ($import as $line) {
                        $line = trim($line);
                        $task    = Mage::getModel('bs_misc/task');
                        $task->setTaskgroupId($taskGroupId);
                        $task->setTaskCode($line);
                        $task->setTaskDesc($line);
                        $task->save();



                    }

                }else {
                    $task->addData($data);
                    $task->save();
                }

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Task was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $task->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTaskData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the task.')
                );
                Mage::getSingleton('adminhtml/session')->setTaskData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find task to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $task = Mage::getModel('bs_misc/task');
                $task->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Task was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting task.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find task to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $taskIds = $this->getRequest()->getParam('task');
        if (!is_array($taskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select tasks to delete.')
            );
        } else {
            try {
                foreach ($taskIds as $taskId) {
                    $task = Mage::getModel('bs_misc/task');
                    $task->setId($taskId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d tasks were successfully deleted.', count($taskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting tasks.')
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
        $taskIds = $this->getRequest()->getParam('task');
        if (!is_array($taskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select tasks.')
            );
        } else {
            try {
                foreach ($taskIds as $taskId) {
                $task = Mage::getSingleton('bs_misc/task')->load($taskId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d tasks were successfully updated.', count($taskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating tasks.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

	public function massPointsAction()
	{
		$taskIds = $this->getRequest()->getParam('task');
		if (!is_array($taskIds)) {
			Mage::getSingleton('adminhtml/session')->addError(
				Mage::helper('bs_misc')->__('Please select tasks.')
			);
		} else {
			try {
				foreach ($taskIds as $taskId) {
					$task = Mage::getSingleton('bs_misc/task')->load($taskId)
					            ->setPoints($this->getRequest()->getParam('points'))
					            ->setIsMassupdate(true)
					            ->save();
				}
				$this->_getSession()->addSuccess(
					$this->__('Total of %d tasks were successfully updated.', count($taskIds))
				);
			} catch (Mage_Core_Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(
					Mage::helper('bs_misc')->__('There was an error updating tasks.')
				);
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}

    /**
     * mass task code group change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massTaskgroupIdAction()
    {
        $taskIds = $this->getRequest()->getParam('task');
        if (!is_array($taskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select tasks.')
            );
        } else {
            try {
                foreach ($taskIds as $taskId) {
                $task = Mage::getSingleton('bs_misc/task')->load($taskId)
                    ->setTaskgroupId($this->getRequest()->getParam('flag_taskgroup_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d tasks were successfully updated.', count($taskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating tasks.')
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
        $fileName   = 'task.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_task_grid')
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
        $fileName   = 'task.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_task_grid')
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
        $fileName   = 'task.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_task_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function updateTasksAction(){
        $result = [];
        $deptId = $this->getRequest()->getPost('dept_id');
        $result['task'] = '<option value="" selected="selected">N/A</option>';
        $taskGroupId = 0;
        if(in_array($deptId, ['1', '3'])){
            $taskGroupId = 2;
        }elseif(in_array($deptId, ['2', '4'])){
            $taskGroupId = 1;
        }elseif(in_array($deptId, ['10', '15'])){
            $taskGroupId = 3;
        }elseif(in_array($deptId, ['6'])){
            $taskGroupId = 9;
        }

        if($deptId){

            $subtasks = Mage::getModel('bs_misc/task')->getCollection()->addFieldToFilter('taskgroup_id', $taskGroupId);


            if($subtasks->count()){
                $text = '';
                foreach ($subtasks as $s) {

                    $text  .= '<option value="'.$s->getId().'">'.$s->getTaskCode().'</option>';
                }
                $result['task'] = $text;
            }
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    public function updateSubtasksAction(){
        $result = [];
        $taskId = $this->getRequest()->getPost('task_id', false);
        $refType = $this->getRequest()->getPost('ref_type');
        $refId = $this->getRequest()->getPost('ref_id');

        if($refId > 0 && $refType != ''){
            $model = Mage::getModel('bs_'.$refType.'/'.$refType)->load($refId);
            $currentSubtasks = $model->getSubtaskId();
            $currentSubtasks = explode(",", $currentSubtasks);
        }
        $full = $this->getRequest()->getPost('full', false);
        $result['subtask'] = '<option value="" selected="selected">N/A</option>';
        if($taskId){

            $subtasks = Mage::getModel('bs_misc/subtask')->getCollection()->addFieldToFilter('task_id', $taskId);


            if($subtasks->count()){
                $text = '';
                foreach ($subtasks as $s) {

                    $label = $s->getSubCode();
                    if($full){
                        $label .= ' - '.Mage::helper('bs_misc')->shorterString($s->getData('sub_desc'), 68);
                    }

                    $selected = (in_array($s->getId(), $currentSubtasks))?'selected = "selected"': '';

                    $text  .= '<option value="'.$s->getId().'" '.$selected.'>'.$label.'</option>';
                }
                $result['subtask'] = $text;
            }
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/task');
    }
}
