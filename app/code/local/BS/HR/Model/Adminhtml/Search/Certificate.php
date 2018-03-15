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
class BS_HR_Model_Adminhtml_Search_Certificate extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_HR_Model_Adminhtml_Search_Certificate
     * @author Bui Phong
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_hr/certificate_collection')
            ->addFieldToFilter('cert_desc', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $certificate) {
            $arr[] = array(
                'id'          => 'certificate/1/'.$certificate->getId(),
                'type'        => Mage::helper('bs_hr')->__('Certificate'),
                'name'        => $certificate->getCertDesc(),
                'description' => $certificate->getCertDesc(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/hr_certificate/edit',
                    array('id'=>$certificate->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
