<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause model
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Model_Ncause extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bs_ncause_ncause';
    const CACHE_TAG = 'bs_ncause_ncause';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bs_ncause_ncause';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'ncause';

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
        $this->_init('bs_ncause/ncause');
    }

    /**
     * before save cause
     *
     * @access protected
     * @return BS_NCause_Model_Ncause
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
     * save cause relation
     *
     * @access public
     * @return BS_NCause_Model_Ncause
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
     * @return null|BS_NCause_Model_Ncausegroup
     * @author Bui Phong
     */
    public function getParentNcausegroup()
    {
        if (!$this->hasData('_parent_ncausegroup')) {
            if (!$this->getNcausegroupId()) {
                return null;
            } else {
                $ncausegroup = Mage::getModel('bs_ncause/ncausegroup')
                    ->load($this->getNcausegroupId());
                if ($ncausegroup->getId()) {
                    $this->setData('_parent_ncausegroup', $ncausegroup);
                } else {
                    $this->setData('_parent_ncausegroup', null);
                }
            }
        }
        return $this->getData('_parent_ncausegroup');
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
