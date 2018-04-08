<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Model_Adminhtml_Search_Mor extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Mor_Model_Adminhtml_Search_Mor
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_mor/mor_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $mor) {
            $arr[] = [
                'id'          => 'mor/1/'.$mor->getId(),
                'type'        => Mage::helper('bs_mor')->__('MOR'),
                'name'        => $mor->getRefNo(),
                'description' => $mor->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/mor_mor/edit',
                    ['id'=>$mor->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
