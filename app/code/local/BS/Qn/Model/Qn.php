<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN model
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Model_Qn extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_qn_qn';
    const CACHE_TAG = 'bs_qn_qn';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_qn_qn';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'qn';

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
        $this->_init('bs_qn/qn');
    }

    /**
     * before save qn
     *
     * @access protected
     * @return BS_Qn_Model_Qn
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
     * save qn relation
     *
     * @access public
     * @return BS_Qn_Model_Qn
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
