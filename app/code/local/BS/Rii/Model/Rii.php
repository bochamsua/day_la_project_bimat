<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off model
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Model_Rii extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_rii_rii';
    const CACHE_TAG = 'bs_rii_rii';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_rii_rii';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'rii';

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
        $this->_init('bs_rii/rii');
    }

    /**
     * before save rii sign-off
     *
     * @access protected
     * @return BS_Rii_Model_Rii
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
     * save rii sign-off relation
     *
     * @access public
     * @return BS_Rii_Model_Rii
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
