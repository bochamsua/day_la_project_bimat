<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Model_Adminhtml_Search_Customer extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Acreg_Model_Adminhtml_Search_Customer
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_acreg/customer_collection')
            ->addFieldToFilter('name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $customer) {
            $arr[] = array(
                'id'          => 'customer/1/'.$customer->getId(),
                'type'        => Mage::helper('bs_acreg')->__('Customer'),
                'name'        => $customer->getName(),
                'description' => $customer->getName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/acreg_customer/edit',
                    array('id'=>$customer->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
