<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer admin edit tabs
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('customer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_acreg')->__('Customer'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Customer_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_customer',
            [
                'label'   => Mage::helper('bs_acreg')->__('Customer'),
                'title'   => Mage::helper('bs_acreg')->__('Customer'),
                'content' => $this->getLayout()->createBlock(
                    'bs_acreg/adminhtml_customer_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve customer entity
     *
     * @access public
     * @return BS_Acreg_Model_Customer
     * @author Bui Phong
     */
    public function getCustomer()
    {
        return Mage::registry('current_customer');
    }
}
