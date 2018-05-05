<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Nrw default helper
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getOngoingWorks($staffId, $type = 'array'){

        if(!$staffId){
            $staffId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        }

        $collection = Mage::getModel('bs_nrw/nrw')
            ->getCollection()
            ->addFieldToFilter('staff_id', $staffId)
            ->addFieldToFilter('nrw_status', [
                ['in' => [1]],
                //['null' => true],
            ])
            ->setOrder('ref_no', 'DESC')

        ;

        $result = '';
        if($collection->count()){
            $works = [];
            foreach ($collection as $item) {

                $url = Mage::getUrl("*/nrw_nrw/edit", ['id' =>$item->getId()]);
                $works[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getRefNo());
            }
            $result = 'Ongoing works ('.$collection->count().'): '.implode(", ", $works);
        }

        return $result;
    }

    public function getExpireWorks($insId, $type = 'array'){

        if(!$insId){
            $insId = Mage::getSingleton('admin/session')->getUser()->getUserId();
        }

        $currentDate = Mage::helper('bs_misc/date')->getNowStoreDate();

        $collection = Mage::getModel('bs_nrw/nrw')
            ->getCollection()
            ->addFieldToFilter('ins_id', $insId)
            ->addFieldToFilter('nrw_status', [
                ['in' => [1]],
                //['null' => true],
            ])
            ->addFieldToFilter('due_date', ['to' => $currentDate])
            ->setOrder('ref_no', 'DESC')

        ;

        $sql = $collection->getSelect()->__toString();

        $result = '';
        if($collection->count()){
            $works = [];
            foreach ($collection as $item) {

                $url = Mage::getUrl("*/nrw_nrw/edit", ['id' =>$item->getId()]);
                $works[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getRefNo());
            }

            if(count($works)){
                $result = 'These works are (going to) expired: '.implode(", ", $works).'<br>';
            }

        }

        return $result;
    }
}
