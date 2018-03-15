<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Model_Adminhtml_Search_Signoff extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Signoff_Model_Adminhtml_Search_Signoff
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_signoff/signoff_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $signoff) {
            $arr[] = array(
                'id'          => 'signoff/1/'.$signoff->getId(),
                'type'        => Mage::helper('bs_signoff')->__('AC Sign-off'),
                'name'        => $signoff->getRefNo(),
                'description' => $signoff->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/signoff_signoff/edit',
                    array('id'=>$signoff->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
