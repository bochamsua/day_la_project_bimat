<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance model
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Model_Field extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_setting_field';
    const CACHE_TAG = 'bs_setting_field';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_setting_field';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'field';

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
        $this->_init('bs_setting/field');
    }

    /**
     * before save field dependance
     *
     * @access protected
     * @return BS_Setting_Model_Field
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
     * save field dependance relation
     *
     * @access public
     * @return BS_Setting_Model_Field
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
