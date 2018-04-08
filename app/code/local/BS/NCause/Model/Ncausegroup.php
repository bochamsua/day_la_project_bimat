<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code model
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Model_Ncausegroup extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_ncause_ncausegroup';
    const CACHE_TAG = 'bs_ncause_ncausegroup';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_ncause_ncausegroup';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'ncausegroup';

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
        $this->_init('bs_ncause/ncausegroup');
    }

    /**
     * before save cause group
     *
     * @access protected
     * @return BS_NCause_Model_Ncausegroup
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
     * save cause group relation
     *
     * @access public
     * @return BS_NCause_Model_Ncausegroup
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
     * @return BS_NCause_Model_Ncause_Collection
     * @author Bui Phong
     */
    public function getSelectedNcausesCollection()
    {
        if (!$this->hasData('_ncause_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('bs_ncause/ncause_collection')
                        ->addFieldToFilter('ncausegroup_id', $this->getId());
                $this->setData('_ncause_collection', $collection);
            }
        }
        return $this->getData('_ncause_collection');
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
