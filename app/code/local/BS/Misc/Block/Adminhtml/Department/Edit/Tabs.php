<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Department admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Department_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('department_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Department'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Department_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_department',
            [
                'label'   => Mage::helper('bs_misc')->__('Department'),
                'title'   => Mage::helper('bs_misc')->__('Department'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_department_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve department entity
     *
     * @access public
     * @return BS_Misc_Model_Department
     * @author Bui Phong
     */
    public function getDepartment()
    {
        return Mage::registry('current_department');
    }
}
