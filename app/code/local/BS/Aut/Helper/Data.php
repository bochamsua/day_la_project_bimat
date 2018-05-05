<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Aut default helper
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getExpireAuts($insId, $type = 'array'){

        if(!$insId){
            $insId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        }

        $currentDate = Mage::helper('bs_misc/date')->getNowStoreDate();

        $collection = Mage::getModel('bs_aut/aut')
            ->getCollection()
            ->addFieldToFilter('ins_id', $insId)
            ->addFieldToFilter('expire_date', ['gt' => $currentDate])
            //->setOrder('', 'DESC')

        ;


        $result = '';
        if($collection->count()){
            $res = [];
            foreach ($collection as $item) {

                $days = Mage::helper('bs_misc/date')->getDays($currentDate, $item->getExpireDate());

                if($days <= 30){
                    $url = Mage::getUrl("*/aut_aut/edit", ['id' =>$item->getId()]);
                    $res[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getApprovalNo());
                }


            }
            if(count($res)){
                $result = 'These Authority Approvals are (going to) expired: '.implode(", ", $res).'<br>';
            }

        }

        return $result;
    }
}
