<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Misc default helper
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Helper_Dept extends BS_Misc_Helper_Data
{
    /**
     * @param $only - Only maintenance center
     */
    public function getDepts($only = true, $grid = true, $withEmpty = false){
        $depts = Mage::getResourceModel('bs_misc/department_collection');

        if($only){
            $depts->addFieldToFilter('entity_id', ['in' => [1,2,3,4,6,10,15]]);
        }
        //test
        if($grid){
            return $depts->toOptionHash();
        }

        $result = $depts->toOptionArray();
        if($withEmpty){
            array_unshift($result, array('value' => 0, 'label' => 'N/A'));
        }

        return $result;

    }

}
