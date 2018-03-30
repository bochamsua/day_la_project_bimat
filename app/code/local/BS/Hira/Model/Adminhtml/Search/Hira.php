<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Model_Adminhtml_Search_Hira extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Hira_Model_Adminhtml_Search_Hira
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_hira/hira_collection')
            ->addFieldToFilter('ref_no', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $hira) {
            $arr[] = array(
                'id'          => 'hira/1/'.$hira->getId(),
                'type'        => Mage::helper('bs_hira')->__('HIRA'),
                'name'        => $hira->getRefNo(),
                'description' => $hira->getRefNo(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/hira_hira/edit',
                    array('id'=>$hira->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
