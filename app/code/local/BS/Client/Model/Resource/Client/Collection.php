<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client collection resource model
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Model_Resource_Client_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_joinedFields = [];

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('bs_client/client');
    }

    /**
     * get clients as array
     *
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author Bui Phong
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='client_id', $additional=[])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }

    /**
     * get options hash
     *
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @return array
     * @author Bui Phong
     */
    protected function _toOptionHash($valueField='entity_id', $labelField='client_id')
    {
        return parent::_toOptionHash($valueField, $labelField);
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @access public
     * @return Varien_Db_Select
     * @author Bui Phong
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
