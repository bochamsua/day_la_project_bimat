<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance model
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Model_Sur extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_sur_sur';
    const CACHE_TAG = 'bs_sur_sur';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_sur_sur';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'sur';

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
        $this->_init('bs_sur/sur');
    }

    /**
     * before save surveillance
     *
     * @access protected
     * @return BS_Sur_Model_Sur
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
     * save surveillance relation
     *
     * @access public
     * @return BS_Sur_Model_Sur
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

    /**
     * get Subtask
     *
     * @access public
     * @return array
     * @author Bui Phong
     */
    public function getSubtaskId()
    {
        if (!$this->getData('subtask_id')) {
            return explode(',', $this->getData('subtask_id'));
        }
        return $this->getData('subtask_id');
    }


}
