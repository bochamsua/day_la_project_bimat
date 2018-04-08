<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature model
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Model_Signature extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_signature_signature';
    const CACHE_TAG = 'bs_signature_signature';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_signature_signature';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'signature';

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
        $this->_init('bs_signature/signature');
    }

    /**
     * before save signature
     *
     * @access protected
     * @return BS_Signature_Model_Signature
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
     * save signature relation
     *
     * @access public
     * @return BS_Signature_Model_Signature
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
