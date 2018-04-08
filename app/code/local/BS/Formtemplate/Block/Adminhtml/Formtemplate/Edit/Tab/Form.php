<?php
/**
 * BS_Formtemplate extension
 * 
 * @category       BS
 * @package        BS_Formtemplate
 * @copyright      Copyright (c) 2015
 */
/**
 * Form Template edit form tab
 *
 * @category    BS
 * @package     BS_Formtemplate
 * @author Bui Phong
 */
class BS_Formtemplate_Block_Adminhtml_Formtemplate_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Formtemplate_Block_Adminhtml_Formtemplate_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('formtemplate_');
        $form->setFieldNameSuffix('formtemplate');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'formtemplate_form',
            ['legend' => Mage::helper('bs_formtemplate')->__('Form Template')]
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_formtemplate/adminhtml_formtemplate_helper_file')
        );

        $fieldset->addField(
            'template_name',
            'text',
            [
                'label' => Mage::helper('bs_formtemplate')->__('Name'),
                'name'  => 'template_name',

            ]
        );

        $fieldset->addField(
            'template_code',
            'text',
            [
                'label' => Mage::helper('bs_formtemplate')->__('Code'),
                'name'  => 'template_code',

            ]
        );

        $fieldset->addField(
            'template_file',
            'file',
            [
                'label' => Mage::helper('bs_formtemplate')->__('File'),
                'name'  => 'template_file',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),

            ]
        );

        $fieldset->addField(
            'template_date',
            'date',
            [
                'label' => Mage::helper('bs_formtemplate')->__('Approved Date'),
                'name'  => 'template_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'template_revision',
            'select',
            [
                'label' => Mage::helper('bs_formtemplate')->__('Revision'),
                'name'  => 'template_revision',

            'values'=> Mage::getModel('bs_formtemplate/formtemplate_attribute_source_templaterevision')->getAllOptions(true),
            ]
        );

        $fieldset->addField(
            'template_note',
            'text',
            [
                'label' => Mage::helper('bs_formtemplate')->__('Note'),
                'name'  => 'template_note',

            ]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'label'  => Mage::helper('bs_formtemplate')->__('Status'),
                'name'   => 'status',
                'values' => [
                    [
                        'value' => 1,
                        'label' => Mage::helper('bs_formtemplate')->__('Enabled'),
                    ],
                    [
                        'value' => 0,
                        'label' => Mage::helper('bs_formtemplate')->__('Disabled'),
                    ],
                ],
            ]
        );
        $formValues = Mage::registry('current_formtemplate')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getFormtemplateData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getFormtemplateData());
            Mage::getSingleton('adminhtml/session')->setFormtemplateData(null);
        } elseif (Mage::registry('current_formtemplate')) {
            $formValues = array_merge($formValues, Mage::registry('current_formtemplate')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
