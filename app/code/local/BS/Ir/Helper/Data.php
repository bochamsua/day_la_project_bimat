<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir default helper
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getNextRefNo($suffix = 'H'){
        $collection    = Mage::getModel('bs_ir/ir')->getCollection();

        //$now = Mage::getModel('core/date')->timestamp(time());
        $dateStart = date('Y-m-d' . ' 00:00:00', time());
        $dateEnd = date('Y-m-d' . ' 23:59:59', time());
	    $year = date('Y', time());
        /*$collection->addFieldToFilter('created_at', array(
            'from' => $dateStart,
            'to' => $dateEnd,
            'date' => true,
        ));*/
	    $collection->addFieldToFilter('ref_no', ['like' => '%-'.$year.'%']);
        $collection->setOrder('entity_id', 'DESC');

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIncrement = intval($lastRefNo[0]);
            $nextIncrement = $lastIncrement + 1;
            if($nextIncrement < 10){
                //$nextIncrement = '0'.$nextIncrement;
            }
            $nextRefNo = sprintf("%s-%s/IR-%s", $nextIncrement, $year, $suffix);

        }else {
            $nextRefNo = sprintf("1-%s/IR-%s", $year, $suffix);
        }

        return $nextRefNo;
    }

    public function createIr($taskGroupId, $taskId, $refId){
        $refNo = $this->getNextRefNo();
        $currentDate = Mage::getModel('core/date')->date('Y-m-d h:m:s');
        $currentIns = Mage::getSingleton('admin/session')->getUser()->getId();
        $data = [];
        $data['ref_no'] = $refNo;
        $data['ins_id'] = $currentIns;
        $data['inspection_date'] = $currentDate;
        $data['taskgroup_id'] = $taskGroupId;
        $data['ref_id'] = $refId;
        $data['task_id'] = $taskId;
	    $data['ir_status'] = 0;//not signed

        $ncr    = Mage::getModel('bs_ir/ir');
        $ncr->addData($data);
        $ncr->save();

        return sprintf("New Ir with reference %s has been raised", $refNo);
    }

}
