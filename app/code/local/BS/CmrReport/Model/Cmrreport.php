<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report model
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Model_Cmrreport extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_cmrreport_cmrreport';
    const CACHE_TAG = 'bs_cmrreport_cmrreport';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_cmrreport_cmrreport';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'cmrreport';

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
        $this->_init('bs_cmrreport/cmrreport');
    }

    /**
     * before save cmr report
     *
     * @access protected
     * @return BS_CmrReport_Model_Cmrreport
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
     * save cmr report relation
     *
     * @access public
     * @return BS_CmrReport_Model_Cmrreport
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
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
