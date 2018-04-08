<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Survey Group admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Taskgroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('taskgroup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Survey Group'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_taskgroup',
            [
                'label'   => Mage::helper('bs_misc')->__('Survey Group'),
                'title'   => Mage::helper('bs_misc')->__('Survey Group'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_taskgroup_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve task code group entity
     *
     * @access public
     * @return BS_Misc_Model_Taskgroup
     * @author Bui Phong
     */
    public function getTaskgroup()
    {
        return Mage::registry('current_taskgroup');
    }
}
