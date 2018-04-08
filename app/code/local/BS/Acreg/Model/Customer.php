<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer model
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Model_Customer extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_acreg_customer';
    const CACHE_TAG = 'bs_acreg_customer';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_acreg_customer';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'customer';

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
        $this->_init('bs_acreg/customer');
    }

    /**
     * before save customer
     *
     * @access protected
     * @return BS_Acreg_Model_Customer
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
     * save customer relation
     *
     * @access public
     * @return BS_Acreg_Model_Customer
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
     * @return BS_Acreg_Model_Acreg_Collection
     * @author Bui Phong
     */
    public function getSelectedAcregsCollection()
    {
        if (!$this->hasData('_acreg_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('bs_acreg/acreg_collection')
                        ->addFieldToFilter('customer_id', $this->getId());
                $this->setData('_acreg_collection', $collection);
            }
        }
        return $this->getData('_acreg_collection');
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
