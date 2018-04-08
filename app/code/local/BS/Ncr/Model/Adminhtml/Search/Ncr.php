<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Model_Adminhtml_Search_Ncr extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Ncr_Model_Adminhtml_Search_Ncr
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_ncr/ncr_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $ncr) {
            $arr[] = [
                'id'          => 'ncr/1/'.$ncr->getId(),
                'type'        => Mage::helper('bs_ncr')->__('NCR'),
                'name'        => $ncr->getRefNo(),
                'description' => $ncr->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/ncr_ncr/edit',
                    ['id'=>$ncr->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
