<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA model
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Model_Meda extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_meda_meda';
    const CACHE_TAG = 'bs_meda_meda';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_meda_meda';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'meda';

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
        $this->_init('bs_meda/meda');
    }

    /**
     * before save meda
     *
     * @access protected
     * @return BS_Meda_Model_Meda
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
     * save meda relation
     *
     * @access public
     * @return BS_Meda_Model_Meda
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
        $values['meda_status'] = '4';

        return $values;
    }
    
}
