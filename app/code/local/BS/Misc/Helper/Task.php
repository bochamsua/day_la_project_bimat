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
class BS_Misc_Helper_Task extends BS_Misc_Helper_Data
{
    public function getMandatorySubtaskFromTaskId($taskId, $sectionId, $subtask = []){
        $subtasks = Mage::getModel('bs_misc/subtask')->getCollection();
        $subtasks->addFieldToFilter('task_id', $taskId);
        if(count($subtask)){
            $subtasks->addFieldToFilter('entity_id', ['in'=>$subtask]);
        }
        if($sectionId && $sectionId == 1){
            $subtasks->addFieldToFilter('is_mandatory', true);
        }


        if($subtasks->count()){
            return $subtasks->count();
        }

        return 0;
    }

}
