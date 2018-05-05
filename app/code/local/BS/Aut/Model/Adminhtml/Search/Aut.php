<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Model_Adminhtml_Search_Aut extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Aut_Model_Adminhtml_Search_Aut
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_aut/aut_collection')
            ->addFieldToFilter('name', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $aut) {
            $arr[] = [
                'id'          => 'aut/1/'.$aut->getId(),
                'type'        => Mage::helper('bs_aut')->__('Authority'),
                'name'        => $aut->getName(),
                'description' => $aut->getName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/aut_aut/edit',
                    ['id'=>$aut->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
