<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir model
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Model_Ir extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_ir_ir';
    const CACHE_TAG = 'bs_ir_ir';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_ir_ir';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'ir';

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
        $this->_init('bs_ir/ir');
    }

    /**
     * before save ir
     *
     * @access protected
     * @return BS_Ir_Model_Ir
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
     * save ir relation
     *
     * @access public
     * @return BS_Ir_Model_Ir
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
