<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Export model
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Model_Ex extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_imex_ex';
    const CACHE_TAG = 'bs_imex_ex';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_imex_ex';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'ex';

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
        $this->_init('bs_imex/ex');
    }

    /**
     * before save export
     *
     * @access protected
     * @return BS_Imex_Model_Ex
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
     * save export relation
     *
     * @access public
     * @return BS_Imex_Model_Ex
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
