<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Aircraft edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Aircraft_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Aircraft_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('aircraft_');
        $form->setFieldNameSuffix('aircraft');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'aircraft_form',
            array('legend' => Mage::helper('bs_misc')->__('Aircraft'))
        );

        $fieldset->addField(
            'ac_name',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Name'),
                'name'  => 'ac_name',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'ac_code',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Code'),
                'name'  => 'ac_code',

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
        $formValues = Mage::registry('current_aircraft')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getAircraftData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getAircraftData());
            Mage::getSingleton('adminhtml/session')->setAircraftData(null);
        } elseif (Mage::registry('current_aircraft')) {
            $formValues = array_merge($formValues, Mage::registry('current_aircraft')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
