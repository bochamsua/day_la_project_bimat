<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Model_Adminhtml_Search_Safety extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Safety_Model_Adminhtml_Search_Safety
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_safety/safety_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $safety) {
            $arr[] = array(
                'id'          => 'safety/1/'.$safety->getId(),
                'type'        => Mage::helper('bs_safety')->__('Safety Data'),
                'name'        => $safety->getRefNo(),
                'description' => $safety->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/safety_safety/edit',
                    array('id'=>$safety->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
