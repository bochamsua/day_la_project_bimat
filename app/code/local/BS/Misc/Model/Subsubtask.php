<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Sub Task model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Subsubtask extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_misc_subsubtask';
    const CACHE_TAG = 'bs_misc_subsubtask';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_misc_subsubtask';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'subsubtask';

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
        $this->_init('bs_misc/subsubtask');
    }

    /**
     * before save sub sub task
     *
     * @access protected
     * @return BS_Misc_Model_Subsubtask
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
     * save sub sub task relation
     *
     * @access public
     * @return BS_Misc_Model_Subsubtask
     * @author Bui Phong
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|BS_Misc_Model_Subtask
     * @author Bui Phong
     */
    public function getParentSubtask()
    {
        if (!$this->hasData('_parent_subtask')) {
            if (!$this->getSubtaskId()) {
                return null;
            } else {
                $subtask = Mage::getModel('bs_misc/subtask')
                    ->load($this->getSubtaskId());
                if ($subtask->getId()) {
                    $this->setData('_parent_subtask', $subtask);
                } else {
                    $this->setData('_parent_subtask', null);
                }
            }
        }
        return $this->getData('_parent_subtask');
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
