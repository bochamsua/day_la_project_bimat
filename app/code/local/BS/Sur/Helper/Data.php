<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Sur default helper
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getNextRefNo($deptId){
        $collection    = Mage::getModel('bs_sur/sur')->getCollection();

        $fromTo = Mage::helper('bs_report')->getFromTo(null, null, true);
        /*$now = Mage::getModel('core/date')->timestamp(time());
        $dateStart = date('Y-m-d' . ' 00:00:00', $now);
        $dateEnd = date('Y-m-d' . ' 23:59:59', $now);
        $formattedDate = date('dmy', $now);*/
        $formattedDate = $fromTo[2];
        $collection->addFieldToFilter('created_at', [
            'from' => $fromTo[0],
            'to' => $fromTo[1],
            'date' => true,
        ]);
        $collection->setOrder('entity_id', 'DESC');

        $type = Mage::getModel('bs_misc/department')->load($deptId)->getDeptCode();
        $type = str_replace(" ", "-", $type);
        $type = strtoupper($type);

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIncrement = intval(end($lastRefNo));
            $nextIncrement = $lastIncrement + 1;
            if($nextIncrement < 10){
                $nextIncrement = '0'.$nextIncrement;
            }
            $nextRefNo = sprintf("SUR-%s-%s-%s",$type, $formattedDate, $nextIncrement);

        }else {
            $nextRefNo = sprintf("SUR-%s-%s-01",$type, $formattedDate);
        }

        return $nextRefNo;
    }
}
