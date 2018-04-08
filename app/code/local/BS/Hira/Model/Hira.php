<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA model
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Model_Hira extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_hira_hira';
    const CACHE_TAG = 'bs_hira_hira';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_hira_hira';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'hira';

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
        $this->_init('bs_hira/hira');
    }

    /**
     * before save hira
     *
     * @access protected
     * @return BS_Hira_Model_Hira
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
     * save hira relation
     *
     * @access public
     * @return BS_Hira_Model_Hira
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
        $values['hira_status'] = '4';

        return $values;
    }
    
}
