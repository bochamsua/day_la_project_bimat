<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off model
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Model_Signoff extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_signoff_signoff';
    const CACHE_TAG = 'bs_signoff_signoff';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_signoff_signoff';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'signoff';

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
        $this->_init('bs_signoff/signoff');
    }

    /**
     * before save sign-off
     *
     * @access protected
     * @return BS_Signoff_Model_Signoff
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
     * save sign-off relation
     *
     * @access public
     * @return BS_Signoff_Model_Signoff
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
