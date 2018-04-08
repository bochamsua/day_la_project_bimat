<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data model
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Model_Kpi extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_kpi_kpi';
    const CACHE_TAG = 'bs_kpi_kpi';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_kpi_kpi';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'kpi';

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
        $this->_init('bs_kpi/kpi');
    }

    /**
     * before save kpi data
     *
     * @access protected
     * @return BS_Kpi_Model_Kpi
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
     * save kpi data relation
     *
     * @access public
     * @return BS_Kpi_Model_Kpi
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
