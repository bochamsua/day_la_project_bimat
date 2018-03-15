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
class BS_Misc_Model_Adminhtml_Search_Subtask extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Subtask
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/subtask_collection')
            ->addFieldToFilter('sub_code', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $subtask) {
            $arr[] = array(
                'id'          => 'subtask/1/'.$subtask->getId(),
                'type'        => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'name'        => $subtask->getSubCode(),
                'description' => $subtask->getSubCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_subtask/edit',
                    array('id'=>$subtask->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
