<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance edit form tab
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Block_Adminhtml_Field_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Setting_Block_Adminhtml_Field_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('field_');
        $form->setFieldNameSuffix('field');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'field_form',
            ['legend' => Mage::helper('bs_setting')->__('Field Dependance')]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => Mage::helper('bs_setting')->__('Field Name Suffix'),
                'name'  => 'name',

            ]
        );

        $fieldset->addField(
            'definition',
            'textarea',
            [
                'label' => Mage::helper('bs_setting')->__('Dependences Definition'),
                'name'  => 'definition',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_setting')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_setting')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_setting')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_field')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getFieldData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getFieldData());
            Mage::getSingleton('adminhtml/session')->setFieldData(null);
        } elseif (Mage::registry('current_field')) {
            $formValues = array_merge($formValues, Mage::registry('current_field')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
