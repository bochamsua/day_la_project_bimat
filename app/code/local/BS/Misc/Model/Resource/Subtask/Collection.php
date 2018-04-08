<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task collection resource model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Resource_Subtask_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
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
        $this->_init('bs_misc/subtask');
    }

    /**
     * get sub tasks as array
     *
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author Bui Phong
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='sub_code', $additional= [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }

    public function toOptionArrayFull()
    {
        return $this->_toOptionArrayFull();
    }

    protected function _toOptionArrayFull($valueField='entity_id', $labelField='sub_code', $additional= [])
    {
        $res = [];
        $additional['value'] = $valueField;
        $additional['label'] = $labelField;

        foreach ($this as $item) {
            foreach ($additional as $code => $field) {
                if($code == 'label'){
                    $shortDesc = Mage::helper('bs_misc')->shorterString($item->getData('sub_desc'), 68);
                    $data[$code] = $item->getData($field).' - '.$shortDesc;
                }else {
                    $data[$code] = $item->getData($field);
                }

            }
            $res[] = $data;
        }
        return $res;
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
    protected function _toOptionHash($valueField='entity_id', $labelField='sub_code')
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
