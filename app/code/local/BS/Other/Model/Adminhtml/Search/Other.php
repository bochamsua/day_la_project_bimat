<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Model_Adminhtml_Search_Other extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Other_Model_Adminhtml_Search_Other
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_other/other_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $other) {
            $arr[] = [
                'id'          => 'other/1/'.$other->getId(),
                'type'        => Mage::helper('bs_other')->__('Other Work'),
                'name'        => $other->getRefNo(),
                'description' => $other->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/other_other/edit',
                    ['id'=>$other->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
