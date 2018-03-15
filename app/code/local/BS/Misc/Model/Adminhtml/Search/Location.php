<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Adminhtml_Search_Location extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Location
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/location_collection')
            ->addFieldToFilter('loc_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $location) {
            $arr[] = array(
                'id'          => 'location/1/'.$location->getId(),
                'type'        => Mage::helper('bs_misc')->__('Location'),
                'name'        => $location->getLocName(),
                'description' => $location->getLocName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_location/edit',
                    array('id'=>$location->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
