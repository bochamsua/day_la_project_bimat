<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Model_Adminhtml_Search_Concession extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Concession_Model_Adminhtml_Search_Concession
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_concession/concession_collection')
            ->addFieldToFilter('name', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $concession) {
            $arr[] = [
                'id'          => 'concession/1/'.$concession->getId(),
                'type'        => Mage::helper('bs_concession')->__('Concession Data'),
                'name'        => $concession->getName(),
                'description' => $concession->getName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/concession_concession/edit',
                    ['id'=>$concession->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
