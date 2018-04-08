<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate Type model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Certtype extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_misc_certtype';
    const CACHE_TAG = 'bs_misc_certtype';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_misc_certtype';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'certtype';

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
        $this->_init('bs_misc/certtype');
    }

    /**
     * before save certificate type
     *
     * @access protected
     * @return BS_Misc_Model_Certtype
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
     * save certificate type relation
     *
     * @access public
     * @return BS_Misc_Model_Certtype
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
