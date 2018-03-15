<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Model_Adminhtml_Search_Rii extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Rii_Model_Adminhtml_Search_Rii
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_rii/rii_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $rii) {
            $arr[] = array(
                'id'          => 'rii/1/'.$rii->getId(),
                'type'        => Mage::helper('bs_rii')->__('RII Sign-off'),
                'name'        => $rii->getRefNo(),
                'description' => $rii->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/rii_rii/edit',
                    array('id'=>$rii->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
