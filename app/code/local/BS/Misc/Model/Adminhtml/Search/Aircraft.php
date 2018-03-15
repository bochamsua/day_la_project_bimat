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
class BS_Misc_Model_Adminhtml_Search_Aircraft extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Aircraft
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/aircraft_collection')
            ->addFieldToFilter('ac_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $aircraft) {
            $arr[] = array(
                'id'          => 'aircraft/1/'.$aircraft->getId(),
                'type'        => Mage::helper('bs_misc')->__('Aircraft'),
                'name'        => $aircraft->getAcName(),
                'description' => $aircraft->getAcName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_aircraft/edit',
                    array('id'=>$aircraft->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
