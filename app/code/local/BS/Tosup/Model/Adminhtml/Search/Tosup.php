<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Model_Adminhtml_Search_Tosup extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Tosup_Model_Adminhtml_Search_Tosup
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_tosup/tosup_collection')
            ->addFieldToFilter('tosup_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $tosup) {
            $arr[] = [
                'id'          => 'tosup/1/'.$tosup->getId(),
                'type'        => Mage::helper('bs_tosup')->__('Tool Supplier'),
                'name'        => $tosup->getTosupNo(),
                'description' => $tosup->getTosupNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/tosup_tosup/edit',
                    ['id'=>$tosup->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
