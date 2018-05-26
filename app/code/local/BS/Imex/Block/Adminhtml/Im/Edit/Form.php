<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Import edit form
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Block_Adminhtml_Im_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return BS_Imex_Block_Adminhtml_Im_Edit_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/start'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('bs_imex')->__('Import Settings')));
        $fieldset->addField('entity', 'select', array(
            'name'     => 'entity',
            'title'    => Mage::helper('bs_imex')->__('Entity Type'),
            'label'    => Mage::helper('bs_imex')->__('Entity Type'),
            'required' => true,
            'values'   => Mage::getModel('bs_imex/source_im_entity')->toOptionArray()
        ));
        $fieldset->addField('behavior', 'select', array(
            'name'     => 'behavior',
            'title'    => Mage::helper('bs_imex')->__('Import Behavior'),
            'label'    => Mage::helper('bs_imex')->__('Import Behavior'),
            'required' => true,
            'values'   => Mage::getModel('bs_imex/source_im_behavior')->toOptionArray()
        ));
        $fieldset->addField('im_source', 'file', array(
            'name'     => 'im_source',
            'label'    => Mage::helper('bs_imex')->__('Select File to Import'),
            'title'    => Mage::helper('bs_imex')->__('Select File to Import'),
            'required' => true
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
