<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Model_Adminhtml_Search_Cmr extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Cmr_Model_Adminhtml_Search_Cmr
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_cmr/cmr_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $cmr) {
            $arr[] = [
                'id'          => 'cmr/1/'.$cmr->getId(),
                'type'        => Mage::helper('bs_cmr')->__('CMR Data'),
                'name'        => $cmr->getRefNo(),
                'description' => $cmr->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/cmr_cmr/edit',
                    ['id'=>$cmr->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
