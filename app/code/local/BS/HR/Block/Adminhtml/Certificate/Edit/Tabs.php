<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate admin edit tabs
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Certificate_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Bui Phong
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('certificate_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_hr')->__('Certificate'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_certificate',
            array(
                'label'   => Mage::helper('bs_hr')->__('Certificate'),
                'title'   => Mage::helper('bs_hr')->__('Certificate'),
                'content' => $this->getLayout()->createBlock(
                    'bs_hr/adminhtml_certificate_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve certificate entity
     *
     * @access public
     * @return BS_HR_Model_Certificate
     * @author Bui Phong
     */
    public function getCertificate()
    {
        return Mage::registry('current_certificate');
    }
}
