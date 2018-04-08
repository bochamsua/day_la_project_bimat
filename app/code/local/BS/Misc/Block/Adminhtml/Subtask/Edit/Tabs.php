<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subtask_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('subtask_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Survey Sub Code'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subtask_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_subtask',
            [
                'label'   => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'title'   => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_subtask_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve sub task entity
     *
     * @access public
     * @return BS_Misc_Model_Subtask
     * @author Bui Phong
     */
    public function getSubtask()
    {
        return Mage::registry('current_subtask');
    }
}
