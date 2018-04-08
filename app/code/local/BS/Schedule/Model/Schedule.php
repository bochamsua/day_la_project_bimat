<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule model
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Model_Schedule extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_schedule_schedule';
    const CACHE_TAG = 'bs_schedule_schedule';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_schedule_schedule';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'schedule';

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
        $this->_init('bs_schedule/schedule');
    }

    /**
     * before save schedule
     *
     * @access protected
     * @return BS_Schedule_Model_Schedule
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
     * save schedule relation
     *
     * @access public
     * @return BS_Schedule_Model_Schedule
     * @author Bui Phong
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
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
