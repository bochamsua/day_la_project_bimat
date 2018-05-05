<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier model
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Model_Sup extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_sup_sup';
    const CACHE_TAG = 'bs_sup_sup';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_sup_sup';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'sup';

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
        $this->_init('bs_sup/sup');
    }

    /**
     * before save supplier
     *
     * @access protected
     * @return BS_Sup_Model_Sup
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
     * save supplier relation
     *
     * @access public
     * @return BS_Sup_Model_Sup
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
