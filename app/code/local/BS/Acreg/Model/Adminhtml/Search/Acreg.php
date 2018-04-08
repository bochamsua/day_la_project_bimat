<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Model_Adminhtml_Search_Acreg extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Acreg_Model_Adminhtml_Search_Acreg
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_acreg/acreg_collection')
            ->addFieldToFilter('reg', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $acreg) {
            $arr[] = [
                'id'          => 'acreg/1/'.$acreg->getId(),
                'type'        => Mage::helper('bs_acreg')->__('A/C Reg'),
                'name'        => $acreg->getReg(),
                'description' => $acreg->getReg(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/acreg_acreg/edit',
                    ['id'=>$acreg->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
