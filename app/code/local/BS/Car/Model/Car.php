<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car model
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Model_Car extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_car_car';
    const CACHE_TAG = 'bs_car_car';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_car_car';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'car';

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
        $this->_init('bs_car/car');
    }

    /**
     * before save car
     *
     * @access protected
     * @return BS_Car_Model_Car
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
     * save car relation
     *
     * @access public
     * @return BS_Car_Model_Car
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
