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
class BS_Misc_Model_Adminhtml_Search_Department extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Misc_Model_Adminhtml_Search_Department
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_misc/department_collection')
            ->addFieldToFilter('dept_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $department) {
            $arr[] = array(
                'id'          => 'department/1/'.$department->getId(),
                'type'        => Mage::helper('bs_misc')->__('Department'),
                'name'        => $department->getDeptName(),
                'description' => $department->getDeptName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/misc_department/edit',
                    array('id'=>$department->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
