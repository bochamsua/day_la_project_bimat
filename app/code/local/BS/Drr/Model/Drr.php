<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr model
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Model_Drr extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_drr_drr';
    const CACHE_TAG = 'bs_drr_drr';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_drr_drr';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'drr';

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
        $this->_init('bs_drr/drr');
    }

    /**
     * before save drr
     *
     * @access protected
     * @return BS_Drr_Model_Drr
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
     * save drr relation
     *
     * @access public
     * @return BS_Drr_Model_Drr
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
