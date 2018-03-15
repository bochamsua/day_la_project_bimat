<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate Type edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Certtype_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Certtype_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('certtype_');
        $form->setFieldNameSuffix('certtype');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'certtype_form',
            array('legend' => Mage::helper('bs_misc')->__('Certificate Type'))
        );

        $fieldset->addField(
            'cert_code',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Code'),
                'name'  => 'cert_code',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'cert_note',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Note'),
                'name'  => 'cert_note',

           )
        );

        $fieldset->addField(
            'import',
            'textarea',
            array(
                'label' => Mage::helper('bs_misc')->__('OR Import from this'),
                'name'  => 'import',

            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_misc')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_misc')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_misc')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_certtype')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCerttypeData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCerttypeData());
            Mage::getSingleton('adminhtml/session')->setCerttypeData(null);
        } elseif (Mage::registry('current_certtype')) {
            $formValues = array_merge($formValues, Mage::registry('current_certtype')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
