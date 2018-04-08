<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Model_Adminhtml_Search_Training extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_HR_Model_Adminhtml_Search_Training
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_hr/training_collection')
            ->addFieldToFilter('training_desc', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $training) {
            $arr[] = [
                'id'          => 'training/1/'.$training->getId(),
                'type'        => Mage::helper('bs_hr')->__('Training'),
                'name'        => $training->getTrainingDesc(),
                'description' => $training->getTrainingDesc(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/hr_training/edit',
                    ['id'=>$training->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
