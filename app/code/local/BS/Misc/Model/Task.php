<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Task model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Task extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_misc_task';
    const CACHE_TAG = 'bs_misc_task';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_misc_task';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'task';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('bs_misc/task');
    }

    /**
     * before save task
     *
     * @access protected
     * @return BS_Misc_Model_Task
     * @author Bui Phong
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save task relation
     *
     * @access public
     * @return BS_Misc_Model_Task
     * @author Bui Phong
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve  collection
     *
     * @access public
     * @return BS_Misc_Model_Subtask_Collection
     * @author Bui Phong
     */
    public function getSelectedSubtasksCollection()
    {
        if (!$this->hasData('_subtask_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('bs_misc/subtask_collection')
                        ->addFieldToFilter('task_id', $this->getId());
                $this->setData('_subtask_collection', $collection);
            }
        }
        return $this->getData('_subtask_collection');
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|BS_Misc_Model_Taskgroup
     * @author Bui Phong
     */
    public function getParentTaskgroup()
    {
        if (!$this->hasData('_parent_taskgroup')) {
            if (!$this->getTaskgroupId()) {
                return null;
            } else {
                $taskgroup = Mage::getModel('bs_misc/taskgroup')
                    ->load($this->getTaskgroupId());
                if ($taskgroup->getId()) {
                    $this->setData('_parent_taskgroup', $taskgroup);
                } else {
                    $this->setData('_parent_taskgroup', null);
                }
            }
        }
        return $this->getData('_parent_taskgroup');
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Bui Phong
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
