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
class BS_Misc_Model_Adminhtml_Search_Subsubtask extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Subsubtask
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/subsubtask_collection')
            ->addFieldToFilter('subsub_code', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $subsubtask) {
            $arr[] = [
                'id'          => 'subsubtask/1/'.$subsubtask->getId(),
                'type'        => Mage::helper('bs_misc')->__('Survey Sub Sub Code'),
                'name'        => $subsubtask->getSubsubCode(),
                'description' => $subsubtask->getSubsubCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_subsubtask/edit',
                    ['id'=>$subsubtask->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
