<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Model_Adminhtml_Search_Sup extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Sup_Model_Adminhtml_Search_Sup
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_sup/sup_collection')
            ->addFieldToFilter('sup_code', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $sup) {
            $arr[] = [
                'id'          => 'sup/1/'.$sup->getId(),
                'type'        => Mage::helper('bs_sup')->__('Supplier'),
                'name'        => $sup->getSupCode(),
                'description' => $sup->getSupCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/sup_sup/edit',
                    ['id'=>$sup->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
