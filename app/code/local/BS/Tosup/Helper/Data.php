<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tosup default helper
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getExpireTosups($insId, $type = 'array'){

        if(!$insId){
            $insId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        }

        $currentDate = Mage::helper('bs_misc/date')->getNowStoreDate();

        $collection = Mage::getModel('bs_tosup/tosup')
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
                    $url = Mage::getUrl("*/tosup_tosup/edit", ['id' =>$item->getId()]);
                    $res[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getTosupNo());
                }


            }

            if(count($res)){
                $result = 'These Tool Suppliers are (going to) expired: '.implode(", ", $res).'<br>';
            }

        }

        return $result;
    }
}
