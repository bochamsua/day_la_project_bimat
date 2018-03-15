<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Location edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Location_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Location_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('location_');
        $form->setFieldNameSuffix('location');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'location_form',
            array('legend' => Mage::helper('bs_misc')->__('Location'))
        );

        $fieldset->addField(
            'loc_name',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Name'),
                'name'  => 'loc_name',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'loc_code',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Code'),
                'name'  => 'loc_code',

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
        $formValues = Mage::registry('current_location')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getLocationData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getLocationData());
            Mage::getSingleton('adminhtml/session')->setLocationData(null);
        } elseif (Mage::registry('current_location')) {
            $formValues = array_merge($formValues, Mage::registry('current_location')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
