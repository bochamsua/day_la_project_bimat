<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Model_Adminhtml_Search_Taskgroup extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Taskgroup
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/taskgroup_collection')
            ->addFieldToFilter('group_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $taskgroup) {
            $arr[] = array(
                'id'          => 'taskgroup/1/'.$taskgroup->getId(),
                'type'        => Mage::helper('bs_misc')->__('Survey Group'),
                'name'        => $taskgroup->getGroupName(),
                'description' => $taskgroup->getGroupName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_taskgroup/edit',
                    array('id'=>$taskgroup->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
