<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance admin edit tabs
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Block_Adminhtml_Field_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('field_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_setting')->__('Field Dependance'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Setting_Block_Adminhtml_Field_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_field',
            [
                'label'   => Mage::helper('bs_setting')->__('Field Dependance'),
                'title'   => Mage::helper('bs_setting')->__('Field Dependance'),
                'content' => $this->getLayout()->createBlock(
                    'bs_setting/adminhtml_field_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve field dependance entity
     *
     * @access public
     * @return BS_Setting_Model_Field
     * @author Bui Phong
     */
    public function getField()
    {
        return Mage::registry('current_field');
    }
}
