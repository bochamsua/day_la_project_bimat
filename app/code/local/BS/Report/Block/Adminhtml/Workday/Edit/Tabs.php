<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Work Day admin edit tabs
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Workday_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('workday_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_report')->__('Work Day'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Workday_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_workday',
            [
                'label'   => Mage::helper('bs_report')->__('Work Day'),
                'title'   => Mage::helper('bs_report')->__('Work Day'),
                'content' => $this->getLayout()->createBlock(
                    'bs_report/adminhtml_workday_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve work day entity
     *
     * @access public
     * @return BS_Report_Model_Workday
     * @author Bui Phong
     */
    public function getWorkday()
    {
        return Mage::registry('current_workday');
    }
}
