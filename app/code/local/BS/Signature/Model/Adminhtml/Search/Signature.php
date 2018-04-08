<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Model_Adminhtml_Search_Signature extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Signature_Model_Adminhtml_Search_Signature
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_signature/signature_collection')
            ->addFieldToFilter('name', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $signature) {
            $arr[] = [
                'id'          => 'signature/1/'.$signature->getId(),
                'type'        => Mage::helper('bs_signature')->__('Signature'),
                'name'        => $signature->getName(),
                'description' => $signature->getName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/signature_signature/edit',
                    ['id'=>$signature->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
