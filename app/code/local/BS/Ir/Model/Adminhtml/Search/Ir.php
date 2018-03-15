<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Model_Adminhtml_Search_Ir extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Ir_Model_Adminhtml_Search_Ir
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_ir/ir_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $ir) {
            $arr[] = array(
                'id'          => 'ir/1/'.$ir->getId(),
                'type'        => Mage::helper('bs_ir')->__('Ir'),
                'name'        => $ir->getRefNo(),
                'description' => $ir->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/ir_ir/edit',
                    array('id'=>$ir->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
