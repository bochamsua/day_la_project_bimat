<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report admin edit tabs
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Block_Adminhtml_Routine_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('routine_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_routine')->__('Routine Report'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Routine_Block_Adminhtml_Routine_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_routine',
            array(
                'label'   => Mage::helper('bs_routine')->__('Routine Report'),
                'title'   => Mage::helper('bs_routine')->__('Routine Report'),
                'content' => $this->getLayout()->createBlock(
                    'bs_routine/adminhtml_routine_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve routine report entity
     *
     * @access public
     * @return BS_Routine_Model_Routine
     * @author Bui Phong
     */
    public function getRoutine()
    {
        return Mage::registry('current_routine');
    }
}
