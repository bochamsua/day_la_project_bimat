<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Survey Group model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Taskgroup extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_misc_taskgroup';
    const CACHE_TAG = 'bs_misc_taskgroup';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_misc_taskgroup';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'taskgroup';

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
        $this->_init('bs_misc/taskgroup');
    }

    /**
     * before save task code group
     *
     * @access protected
     * @return BS_Misc_Model_Taskgroup
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
     * save task code group relation
     *
     * @access public
     * @return BS_Misc_Model_Taskgroup
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
     * @return BS_Misc_Model_Task_Collection
     * @author Bui Phong
     */
    public function getSelectedTasksCollection()
    {
        if (!$this->hasData('_task_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('bs_misc/task_collection')
                        ->addFieldToFilter('taskgroup_id', $this->getId());
                $this->setData('_task_collection', $collection);
            }
        }
        return $this->getData('_task_collection');
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
