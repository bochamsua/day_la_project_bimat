<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Sup default helper
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getExpireSups($insId, $type = 'array'){

        if(!$insId){
            $insId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        }

        $currentDate = Mage::helper('bs_misc/date')->getNowStoreDate();

        $collection = Mage::getModel('bs_sup/sup')
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
                    $url = Mage::getUrl("*/sup_sup/edit", ['id' =>$item->getId()]);
                    $res[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getSupCode());
                }


            }

            if(count($res)){
                $result = 'These Suppliers are (going to) expired: '.implode(", ", $res).'<br>';
            }

        }

        return $result;
    }
}
