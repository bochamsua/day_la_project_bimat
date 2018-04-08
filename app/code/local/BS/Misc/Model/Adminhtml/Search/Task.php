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
class BS_Misc_Model_Adminhtml_Search_Task extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Task
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/task_collection')
            ->addFieldToFilter('task_code', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $task) {
            $arr[] = [
                'id'          => 'task/1/'.$task->getId(),
                'type'        => Mage::helper('bs_misc')->__('Survey Code'),
                'name'        => $task->getTaskCode(),
                'description' => $task->getTaskCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_task/edit',
                    ['id'=>$task->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
