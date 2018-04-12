<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Model_Adminhtml_Search_Nrw extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Nrw_Model_Adminhtml_Search_Nrw
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_nrw/nrw_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $nrw) {
            $arr[] = [
                'id'          => 'nrw/1/'.$nrw->getId(),
                'type'        => Mage::helper('bs_nrw')->__('Non-routine Work'),
                'name'        => $nrw->getRefNo(),
                'description' => $nrw->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/nrw_nrw/edit',
                    ['id'=>$nrw->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
