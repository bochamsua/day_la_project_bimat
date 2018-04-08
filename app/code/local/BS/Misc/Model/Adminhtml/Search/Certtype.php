<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Adminhtml_Search_Certtype extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Certtype
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/certtype_collection')
            ->addFieldToFilter('cert_code', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $certtype) {
            $arr[] = [
                'id'          => 'certtype/1/'.$certtype->getId(),
                'type'        => Mage::helper('bs_misc')->__('Certificate Type'),
                'name'        => $certtype->getCertCode(),
                'description' => $certtype->getCertCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_certtype/edit',
                    ['id'=>$certtype->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
