<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Model_Adminhtml_Search_Coa extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Coa_Model_Adminhtml_Search_Coa
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_coa/coa_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $coa) {
            $arr[] = [
                'id'          => 'coa/1/'.$coa->getId(),
                'type'        => Mage::helper('bs_coa')->__('Corrective Action'),
                'name'        => $coa->getRefNo(),
                'description' => $coa->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/coa_coa/edit',
                    ['id'=>$coa->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
