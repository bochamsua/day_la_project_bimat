<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority admin edit tabs
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Block_Adminhtml_Aut_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('aut_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_aut')->__('Authority'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Aut_Block_Adminhtml_Aut_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_aut',
            [
                'label'   => Mage::helper('bs_aut')->__('Authority'),
                'title'   => Mage::helper('bs_aut')->__('Authority'),
                'content' => $this->getLayout()->createBlock(
                    'bs_aut/adminhtml_aut_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve authority entity
     *
     * @access public
     * @return BS_Aut_Model_Aut
     * @author Bui Phong
     */
    public function getAut()
    {
        return Mage::registry('current_aut');
    }
}
