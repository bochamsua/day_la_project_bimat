<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data model
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Model_Cmr extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_cmr_cmr';
    const CACHE_TAG = 'bs_cmr_cmr';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_cmr_cmr';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'cmr';

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
        $this->_init('bs_cmr/cmr');
    }

    /**
     * before save cmr
     *
     * @access protected
     * @return BS_Cmr_Model_Cmr
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
     * save cmr relation
     *
     * @access public
     * @return BS_Cmr_Model_Cmr
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
