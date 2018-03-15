<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Model_Adminhtml_Search_Cofa extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Cofa_Model_Adminhtml_Search_Cofa
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_cofa/cofa_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $cofa) {
            $arr[] = array(
                'id'          => 'cofa/1/'.$cofa->getId(),
                'type'        => Mage::helper('bs_cofa')->__('CoA Data'),
                'name'        => $cofa->getRefNo(),
                'description' => $cofa->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/cofa_cofa/edit',
                    array('id'=>$cofa->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
