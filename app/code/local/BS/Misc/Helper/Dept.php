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

    public function getMaintenanceCenters(){
        return [1,2,3,4,6,10,15];
    }

    /**
     * @param $only - Only maintenance center
     */
    public function getDepts($only = true, $grid = true, $withEmpty = false){

        $maintenanceCenters = $this->getMaintenanceCenters();

        $depts = Mage::getResourceModel('bs_misc/department_collection');

        if($only){
            $depts->addFieldToFilter('entity_id', ['in' => $maintenanceCenters]);
        }
        if($grid){
            return $depts->toOptionHash();
        }

        $result = $depts->toOptionArray();
        if($withEmpty){
            array_unshift($result, ['value' => 0, 'label' => 'N/A']);
        }

        return $result;

    }



}
