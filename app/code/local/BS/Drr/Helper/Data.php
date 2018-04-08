<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr default helper
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Bui Phong
     */
    public function convertOptions($options)
    {
        $converted = [];
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    public function getNextRefNo($regionId){

        $suffix = Mage::helper('bs_misc')->getRegionSuffix($regionId);

        $collection    = Mage::getModel('bs_drr/drr')->getCollection();

        $now = Mage::getModel('core/date')->timestamp(time());
        $year = date('Y', $now);
        $collection->addFieldToFilter('ref_no', ['like' => '%-'.$year.'%']);
        $collection->setOrder('entity_id', 'DESC');

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIdrrement = intval($lastRefNo[0]);
            $nextIdrrement = $lastIdrrement + 1;
            if($nextIdrrement < 10){
                //$nextIdrrement = '0'.$nextIdrrement;
            }
            $nextRefNo = sprintf("%s-%s/DRR-%s", $nextIdrrement, $year, $suffix);

        }else {
            $nextRefNo = sprintf("1-%s/DRR-%s", $year, $suffix);
        }

        return $nextRefNo;
    }

    public function createDrr($refId, $refType = null, $inputData){

        if(isset($inputData['drr']) && $inputData['drr'] == 1 && isset($inputData['subtask_id'])){
            $subtasks = $inputData['subtask_id'];
            $this->removeDrr($refId, $refType, $subtasks);
            $messages = [];
            $currentDate = Mage::helper('bs_misc/date')->getNowUtcDate();
            //$currentIns = Mage::helper('bs_misc')->getCurrentUserInfo();

            foreach ($subtasks as $subtask) {

                if(!$this->checkDrr($refId, $refType, $subtask )){
                    $refNo = $this->getNextRefNo($inputData['region']);

                    $data = [];
                    $data['ref_no'] = $refNo;
                    $data['ins_id'] = $inputData['ins_id'];
                    $data['role_id'] = $inputData['role_id'];
                    $data['report_date'] = $currentDate;
                    $data['drr_status'] = 0;//open
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

                    //$data['due_date'] = Mage::getModel('core/date')->date('Y-m-d h:m:s', strtotime($currentDate." +10 days"));

                    $drr    = Mage::getModel('bs_drr/drr');
                    $drr->addData($data);
                    $drr->save();

                    $messages[] = sprintf("New DRR with reference %s has been raised", $refNo);
                }

            }

        }else {
            $this->removeDrr($refId, $refType);
        }

        return $messages;

    }

    public function removeDrr($refId, $refType, $excludeSubtask = []){
        $drr = Mage::getModel('bs_drr/drr')->getCollection();
        $drr->addFieldToFilter('ref_id', $refId);
        $drr->addFieldToFilter('ref_type', $refType);

        if(count($excludeSubtask)){
            $drr->addFieldToFilter('subtask_id', ['nin' => $excludeSubtask]);
        }

        if($drr->count()){
            $drr->walk('delete');
        }

    }

    public function checkDrr($refId, $refType, $subtaskId){
        $drr = Mage::getModel('bs_drr/drr')->getCollection();
        $drr->addFieldToFilter('ref_id', $refId);
        $drr->addFieldToFilter('ref_type', $refType);
        $drr->addFieldToFilter('subtask_id', $subtaskId);

        if($drr->count()){
            return true;
        }

        return false;

    }
}
