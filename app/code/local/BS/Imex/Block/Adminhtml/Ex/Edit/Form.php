<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Export edit form
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Block_Adminhtml_Ex_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return BS_Imex_Block_Adminhtml_Ex_Edit_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/getFilter'),
            'method' => 'post'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('bs_imex')->__('Export Settings')));
        $fieldset->addField('entity', 'select', array(
            'name'     => 'entity',
            'title'    => Mage::helper('bs_imex')->__('Entity Type'),
            'label'    => Mage::helper('bs_imex')->__('Entity Type'),
            'required' => false,
            'onchange' => 'editForm.getFilter();',
            'values'   => Mage::getModel('bs_imex/source_ex_entity')->toOptionArray()
        ));
        $fieldset->addField('file_format', 'select', array(
            'name'     => 'file_format',
            'title'    => Mage::helper('bs_imex')->__('Export File Format'),
            'label'    => Mage::helper('bs_imex')->__('Export File Format'),
            'required' => false,
            'values'   => Mage::getModel('bs_imex/source_ex_format')->toOptionArray()
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
