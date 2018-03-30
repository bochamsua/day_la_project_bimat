<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Model_Adminhtml_Search_Meda extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Meda_Model_Adminhtml_Search_Meda
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_meda/meda_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $meda) {
            $arr[] = array(
                'id'          => 'meda/1/'.$meda->getId(),
                'type'        => Mage::helper('bs_meda')->__('MEDA'),
                'name'        => $meda->getRefNo(),
                'description' => $meda->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/meda_meda/edit',
                    array('id'=>$meda->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
