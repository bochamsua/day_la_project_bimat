<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA admin edit tabs
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Block_Adminhtml_Meda_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('meda_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_meda')->__('MEDA'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Meda_Block_Adminhtml_Meda_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_meda',
            array(
                'label'   => Mage::helper('bs_meda')->__('MEDA'),
                'title'   => Mage::helper('bs_meda')->__('MEDA'),
                'content' => $this->getLayout()->createBlock(
                    'bs_meda/adminhtml_meda_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve meda entity
     *
     * @access public
     * @return BS_Meda_Model_Meda
     * @author Bui Phong
     */
    public function getMeda()
    {
        return Mage::registry('current_meda');
    }
}
