<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Model_Adminhtml_Search_Qr extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Qr_Model_Adminhtml_Search_Qr
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_qr/qr_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $qr) {
            $arr[] = array(
                'id'          => 'qr/1/'.$qr->getId(),
                'type'        => Mage::helper('bs_qr')->__('QR'),
                'name'        => $qr->getRefNo(),
                'description' => $qr->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/qr_qr/edit',
                    array('id'=>$qr->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
