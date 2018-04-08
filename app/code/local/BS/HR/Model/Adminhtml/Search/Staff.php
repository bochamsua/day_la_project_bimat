<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Model_Adminhtml_Search_Staff extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_HR_Model_Adminhtml_Search_Staff
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_hr/staff_collection')
            ->addFieldToFilter('user_id', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $staff) {
            $arr[] = [
                'id'          => 'staff/1/'.$staff->getId(),
                'type'        => Mage::helper('bs_hr')->__('Staff'),
                'name'        => $staff->getUserId(),
                'description' => $staff->getUserId(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/hr_staff/edit',
                    ['id'=>$staff->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
