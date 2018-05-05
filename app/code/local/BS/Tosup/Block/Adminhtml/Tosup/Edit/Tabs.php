<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier admin edit tabs
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Block_Adminhtml_Tosup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('tosup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_tosup')->__('Tool Supplier'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Tosup_Block_Adminhtml_Tosup_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_tosup',
            [
                'label'   => Mage::helper('bs_tosup')->__('Tool Supplier'),
                'title'   => Mage::helper('bs_tosup')->__('Tool Supplier'),
                'content' => $this->getLayout()->createBlock(
                    'bs_tosup/adminhtml_tosup_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve tool supplier entity
     *
     * @access public
     * @return BS_Tosup_Model_Tosup
     * @author Bui Phong
     */
    public function getTosup()
    {
        return Mage::registry('current_tosup');
    }
}
