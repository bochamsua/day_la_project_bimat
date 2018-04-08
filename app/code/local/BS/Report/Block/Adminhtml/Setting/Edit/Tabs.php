<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Setting admin edit tabs
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Setting_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('setting_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_report')->__('Setting'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Setting_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_setting',
            [
                'label'   => Mage::helper('bs_report')->__('Setting'),
                'title'   => Mage::helper('bs_report')->__('Setting'),
                'content' => $this->getLayout()->createBlock(
                    'bs_report/adminhtml_setting_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve setting entity
     *
     * @access public
     * @return BS_Report_Model_Setting
     * @author Bui Phong
     */
    public function getSetting()
    {
        return Mage::registry('current_setting');
    }
}
