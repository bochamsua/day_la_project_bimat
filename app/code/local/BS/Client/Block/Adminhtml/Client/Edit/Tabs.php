<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client admin edit tabs
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Block_Adminhtml_Client_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('client_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_client')->__('Client'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Client_Block_Adminhtml_Client_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_client',
            [
                'label'   => Mage::helper('bs_client')->__('Client'),
                'title'   => Mage::helper('bs_client')->__('Client'),
                'content' => $this->getLayout()->createBlock(
                    'bs_client/adminhtml_client_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve client entity
     *
     * @access public
     * @return BS_Client_Model_Client
     * @author Bui Phong
     */
    public function getClient()
    {
        return Mage::registry('current_client');
    }
}
