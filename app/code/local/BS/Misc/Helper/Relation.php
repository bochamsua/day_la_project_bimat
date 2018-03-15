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
class BS_Misc_Helper_Relation extends BS_Misc_Helper_Data
{

    public function createRelation($refId, $refType, $data){

        $message = [];

        foreach ($this->_relations as $relation) {
            $msg = $this->createObj($relation, $refId, $refType, $data);
            $message = array_merge($message, $msg);
        }

        return $message;

    }


    public function updateParent($refId, $refType, $child,  $count = 0){
        if($refId && $refType){
            $obj    = Mage::getModel("bs_{$refType}/{$refType}")->load($refId);
            if($count > 0){
                $obj->setData($child, true);
            }else {
                $obj->setData($child, false);
            }
            $obj->save();
        }
    }

    public function countRelation($refId, $refType, $specific = null){
        if(!$specific){
            $result = [];
            foreach ($this->_relations as $relation) {

                $obj    = Mage::getModel("bs_{$relation}/{$relation}")->getCollection();
                $obj->addFieldToFilter('ref_id', $refId);
                $obj->addFieldToFilter('ref_type', $refType);

                $count  = 0;
                if($obj->count()){
                    $count = $obj->count();
                }

                $result[$relation] = $count;
            }

            return $result;
        }else {
            if(in_array($specific, $this->_relations)){
                $obj    = Mage::getModel("bs_{$specific}/{$specific}")->getCollection();
                $obj->addFieldToFilter('ref_id', $refId);
                $obj->addFieldToFilter('ref_type', $refType);

                $count  = 0;
                if($obj->count()){
                    $count = $obj->count();
                }

                $this->updateParent($refId, $refType, $specific, $count);

                return $count;
            }

            return 0;

        }

    }

    public function doBeforeDeleteChildren($childId, $childType){
        if($childId && $childType){
            //we need to update parent to set the option Yes/No
            $obj    = Mage::getModel("bs_{$childType}/{$childType}");
            if($obj){
                $obj->load($childId);
                $refType = $obj->getRefType();
                $refId = $obj->getRefId();
                if($refType != '' && $refId > 0){
                    $count = $this->countRelation($refId, $refType, $childType);
                    $this->updateParent($refId, $refType, $childType, $count - 1);//we need to -1 because this happens before we delete
                }
            }

        }


    }

    public function deleteRelation($refId, $refType){


        $message = [];

        foreach ($this->_relations as $relation) {

            $obj    = Mage::getModel("bs_{$relation}/{$relation}")->getCollection();
            $obj->addFieldToFilter('ref_id', $refId);
            $obj->addFieldToFilter('ref_type', $refType);

            if($obj->count()){
                foreach ($obj as $item) {
                    $messages[] = sprintf("%s: %s has been deleted.", strtoupper($relation), $item->getRefNo());
                    $item->delete();
                }
            }
        }

        return $message;

    }



    public function createObj($type, $refId, $refType = null, $inputData){

        if(isset($inputData[$type]) && $inputData[$type] == 1 && isset($inputData['subtask_id'])){
            $subtasks = $inputData['subtask_id'];
            $this->removeObj($type, $refId, $refType, $subtasks);
            $messages = [];
            $currentDate = Mage::helper('bs_misc/date')->getNowUtcDate();
            //$currentIns = Mage::helper('bs_misc')->getCurrentUserInfo();

            foreach ($subtasks as $subtask) {

                if(!$this->checkObj($type, $refId, $refType, $subtask )){
                    $refNo = $this->getNextRefNo($type, $inputData['region']);

                    $data = [];
                    $data['ref_no'] = $refNo;
                    $data['ins_id'] = $inputData['ins_id'];
                    //$data['role_id'] = $inputData['role_id'];
                    $data['report_date'] = $currentDate;
                    $data[$type.'_status'] = 0;//not signed
                    $data['taskgroup_id'] = $inputData['taskgroup_id'];
                    $data['task_id'] = $inputData['task_id'];
                    $data['subtask_id'] = $subtask;
                    $data['dept_id'] = $inputData['dept_id'];
                    $data['loc_id'] = $inputData['loc_id'];
                    $data['customer'] = $inputData['customer'];
                    $data['ac_type']   = $inputData['ac_type'];
                    $data['ac_reg']    = $inputData['ac_reg'];
                    $data['region']   = $inputData['region'];
                    $data['section']   = $inputData['section'];

                    $data['ref_id'] = $refId;
                    $data['ref_type'] = $refType;

                    $data['due_date'] = Mage::getModel('core/date')->date('Y-m-d h:m:s', strtotime($currentDate." +10 days"));

                    $obj    = Mage::getModel("bs_{$type}/{$type}");
                    $obj->addData($data);
                    $obj->save();

                    $messages[] = sprintf("New %s with reference %s has been raised", strtoupper($type),  $refNo);
                }

            }

        }else {
            $this->removeObj($type, $refId, $refType);
        }

        return $messages;

    }

    public function removeObj($type, $refId, $refType, $excludeSubtask = []){
        $obj = Mage::getModel("bs_{$type}/{$type}")->getCollection();
        $obj->addFieldToFilter('ref_id', $refId);
        $obj->addFieldToFilter('ref_type', $refType);

        if(count($excludeSubtask)){
            $obj->addFieldToFilter('subtask_id', ['nin' => $excludeSubtask]);
        }

        if($obj->count()){
            $obj->walk('delete');
        }

    }

    public function checkObj($type, $refId, $refType, $subtaskId){
        $obj = Mage::getModel("bs_{$type}/{$type}")->getCollection();
        $obj->addFieldToFilter('ref_id', $refId);
        $obj->addFieldToFilter('ref_type', $refType);
        $obj->addFieldToFilter('subtask_id', $subtaskId);

        if($obj->count()){
            return true;
        }

        return false;

    }

}
