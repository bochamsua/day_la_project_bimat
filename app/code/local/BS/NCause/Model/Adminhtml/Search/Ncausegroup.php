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
class BS_NCause_Model_Adminhtml_Search_Ncausegroup extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_NCause_Model_Adminhtml_Search_Ncausegroup
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_ncause/ncausegroup_collection')
            ->addFieldToFilter('group_code', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $ncausegroup) {
            $arr[] = array(
                'id'          => 'ncausegroup/1/'.$ncausegroup->getId(),
                'type'        => Mage::helper('bs_ncause')->__('Root Cause Code'),
                'name'        => $ncausegroup->getGroupCode(),
                'description' => $ncausegroup->getGroupCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/ncause_ncausegroup/edit',
                    array('id'=>$ncausegroup->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
