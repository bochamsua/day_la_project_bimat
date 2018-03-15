<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report model
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Model_Routine extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_routine_routine';
    const CACHE_TAG = 'bs_routine_routine';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_routine_routine';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'routine';

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
        $this->_init('bs_routine/routine');
    }

    /**
     * before save routine report
     *
     * @access protected
     * @return BS_Routine_Model_Routine
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
     * save routine report relation
     *
     * @access public
     * @return BS_Routine_Model_Routine
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
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
