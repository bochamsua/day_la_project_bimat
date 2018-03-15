<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Model_Adminhtml_Search_Sur extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Sur_Model_Adminhtml_Search_Sur
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_sur/sur_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $sur) {
            $arr[] = array(
                'id'          => 'sur/1/'.$sur->getId(),
                'type'        => Mage::helper('bs_sur')->__('Surveillance'),
                'name'        => $sur->getRefNo(),
                'description' => $sur->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/sur_sur/edit',
                    array('id'=>$sur->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
