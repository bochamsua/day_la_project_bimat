<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg admin edit tabs
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Acreg_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('acreg_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_acreg')->__('A/C Reg'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Acreg_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_acreg',
            array(
                'label'   => Mage::helper('bs_acreg')->__('A/C Reg'),
                'title'   => Mage::helper('bs_acreg')->__('A/C Reg'),
                'content' => $this->getLayout()->createBlock(
                    'bs_acreg/adminhtml_acreg_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve a/c reg entity
     *
     * @access public
     * @return BS_Acreg_Model_Acreg
     * @author Bui Phong
     */
    public function getAcreg()
    {
        return Mage::registry('current_acreg');
    }
}
