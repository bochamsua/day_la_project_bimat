<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature admin edit tabs
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Block_Adminhtml_Signature_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('signature_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_signature')->__('Signature'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_signature',
            array(
                'label'   => Mage::helper('bs_signature')->__('Signature'),
                'title'   => Mage::helper('bs_signature')->__('Signature'),
                'content' => $this->getLayout()->createBlock(
                    'bs_signature/adminhtml_signature_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve signature entity
     *
     * @access public
     * @return BS_Signature_Model_Signature
     * @author Bui Phong
     */
    public function getSignature()
    {
        return Mage::registry('current_signature');
    }
}
