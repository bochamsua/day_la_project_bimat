<?php
/**
 * BS_Docx extension
 * 
 * @category       BS
 * @package        BS_Docx
 * @copyright      Copyright (c) 2016
 */
/**
 * Docx model
 *
 * @category    BS
 * @package     BS_Docx
 * @author Bui Phong
 */
class BS_Docx_Model_Docx extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_docx_docx';
    const CACHE_TAG = 'bs_docx_docx';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_docx_docx';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'docx';

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
        $this->_init('bs_docx/docx');
    }

    /**
     * before save docx
     *
     * @access protected
     * @return BS_Docx_Model_Docx
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
     * save docx relation
     *
     * @access public
     * @return BS_Docx_Model_Docx
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
