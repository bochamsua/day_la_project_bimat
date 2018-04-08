<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Model_Adminhtml_Search_Qn extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Qn_Model_Adminhtml_Search_Qn
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_qn/qn_collection')
            ->addFieldToFilter('ref_no', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $qn) {
            $arr[] = [
                'id'          => 'qn/1/'.$qn->getId(),
                'type'        => Mage::helper('bs_qn')->__('QN'),
                'name'        => $qn->getRefNo(),
                'description' => $qn->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/qn_qn/edit',
                    ['id'=>$qn->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
