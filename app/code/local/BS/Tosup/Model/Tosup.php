<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier model
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Model_Tosup extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_tosup_tosup';
    const CACHE_TAG = 'bs_tosup_tosup';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_tosup_tosup';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'tosup';

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
        $this->_init('bs_tosup/tosup');
    }

    /**
     * before save tool supplier
     *
     * @access protected
     * @return BS_Tosup_Model_Tosup
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
     * save tool supplier relation
     *
     * @access public
     * @return BS_Tosup_Model_Tosup
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
        $values['sup_status'] = '4';

        return $values;
    }
    
}
