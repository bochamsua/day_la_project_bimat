<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Subtask extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_misc_subtask';
    const CACHE_TAG = 'bs_misc_subtask';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_misc_subtask';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'subtask';

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
        $this->_init('bs_misc/subtask');
    }

    /**
     * before save sub task
     *
     * @access protected
     * @return BS_Misc_Model_Subtask
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
     * save sub task relation
     *
     * @access public
     * @return BS_Misc_Model_Subtask
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
     * @return BS_Misc_Model_Subsubtask_Collection
     * @author Bui Phong
     */
    public function getSelectedSubsubtasksCollection()
    {
        if (!$this->hasData('_subsubtask_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('bs_misc/subsubtask_collection')
                        ->addFieldToFilter('subtask_id', $this->getId());
                $this->setData('_subsubtask_collection', $collection);
            }
        }
        return $this->getData('_subsubtask_collection');
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|BS_Misc_Model_Task
     * @author Bui Phong
     */
    public function getParentTask()
    {
        if (!$this->hasData('_parent_task')) {
            if (!$this->getTaskId()) {
                return null;
            } else {
                $task = Mage::getModel('bs_misc/task')
                    ->load($this->getTaskId());
                if ($task->getId()) {
                    $this->setData('_parent_task', $task);
                } else {
                    $this->setData('_parent_task', null);
                }
            }
        }
        return $this->getData('_parent_task');
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
        $values = [];
        $values['status'] = 1;
        return $values;
    }
    
}
