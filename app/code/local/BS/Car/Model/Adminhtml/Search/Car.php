<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Model_Adminhtml_Search_Car extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Car_Model_Adminhtml_Search_Car
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_car/car_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $car) {
            $arr[] = [
                'id'          => 'car/1/'.$car->getId(),
                'type'        => Mage::helper('bs_car')->__('Car'),
                'name'        => $car->getRefNo(),
                'description' => $car->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/car_car/edit',
                    ['id'=>$car->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
