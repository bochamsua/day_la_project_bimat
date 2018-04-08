<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg model
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Model_Acreg extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_acreg_acreg';
    const CACHE_TAG = 'bs_acreg_acreg';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_acreg_acreg';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'acreg';

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
        $this->_init('bs_acreg/acreg');
    }

    /**
     * before save a/c reg
     *
     * @access protected
     * @return BS_Acreg_Model_Acreg
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
     * save a/c reg relation
     *
     * @access public
     * @return BS_Acreg_Model_Acreg
     * @author Bui Phong
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|BS_Acreg_Model_Customer
     * @author Bui Phong
     */
    public function getParentCustomer()
    {
        if (!$this->hasData('_parent_customer')) {
            if (!$this->getCustomerId()) {
                return null;
            } else {
                $customer = Mage::getModel('bs_acreg/customer')
                    ->load($this->getCustomerId());
                if ($customer->getId()) {
                    $this->setData('_parent_customer', $customer);
                } else {
                    $this->setData('_parent_customer', null);
                }
            }
        }
        return $this->getData('_parent_customer');
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
