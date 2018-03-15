<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Model_Adminhtml_Search_Drr extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Drr_Model_Adminhtml_Search_Drr
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_drr/drr_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $drr) {
            $arr[] = array(
                'id'          => 'drr/1/'.$drr->getId(),
                'type'        => Mage::helper('bs_drr')->__('Drr'),
                'name'        => $drr->getRefNo(),
                'description' => $drr->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/drr_drr/edit',
                    array('id'=>$drr->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
