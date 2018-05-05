<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier admin edit tabs
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Block_Adminhtml_Sup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('sup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_sup')->__('Supplier'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Sup_Block_Adminhtml_Sup_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_sup',
            [
                'label'   => Mage::helper('bs_sup')->__('Supplier'),
                'title'   => Mage::helper('bs_sup')->__('Supplier'),
                'content' => $this->getLayout()->createBlock(
                    'bs_sup/adminhtml_sup_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve supplier entity
     *
     * @access public
     * @return BS_Sup_Model_Sup
     * @author Bui Phong
     */
    public function getSup()
    {
        return Mage::registry('current_sup');
    }
}
