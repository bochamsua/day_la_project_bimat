<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Model_Adminhtml_Search_Ncause extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_NCause_Model_Adminhtml_Search_Ncause
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_ncause/ncause_collection')
            ->addFieldToFilter('cause_code', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $ncause) {
            $arr[] = array(
                'id'          => 'ncause/1/'.$ncause->getId(),
                'type'        => Mage::helper('bs_ncause')->__('Root Cause Sub Code'),
                'name'        => $ncause->getCauseCode(),
                'description' => $ncause->getCauseCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/ncause_ncause/edit',
                    array('id'=>$ncause->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
