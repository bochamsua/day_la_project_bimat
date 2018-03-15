<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger model
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Model_Logger extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_logger_logger';
    const CACHE_TAG = 'bs_logger_logger';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_logger_logger';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'logger';

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
        $this->_init('bs_logger/logger');
    }

    public function saveLog($message, array $content = array())
    {
        try {
            $db =   Mage::getModel('bs_logger/logger');
            $db->setUserId(Mage::getSingleton('admin/session')->getUser()->getUserId());
            $db->setMessage($message);
            $db->setIp(Mage::helper('core/http')->getRemoteAddr());
            $db->setContent(serialize($content));

            return $db->save();

        } catch (Exception $e) {

            Mage::logException($e);

        }
    }


    /**
     * before save logger
     *
     * @access protected
     * @return BS_Logger_Model_Logger
     * @author Bui Phong
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->date();//gmtDate()
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save logger relation
     *
     * @access public
     * @return BS_Logger_Model_Logger
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
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
