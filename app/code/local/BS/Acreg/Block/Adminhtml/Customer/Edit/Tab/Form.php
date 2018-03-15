<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer edit form tab
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Customer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Customer_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('customer_');
        $form->setFieldNameSuffix('customer');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'customer_form',
            array('legend' => Mage::helper('bs_acreg')->__('Customer'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('bs_acreg')->__('Name'),
                'name'  => 'name',

           )
        );

        $fieldset->addField(
            'code',
            'text',
            array(
                'label' => Mage::helper('bs_acreg')->__('Code'),
                'name'  => 'code',

           )
        );

        $fieldset->addField(
            'note',
            'text',
            array(
                'label' => Mage::helper('bs_acreg')->__('Note'),
                'name'  => 'note',

           )
        );

        $formValues = Mage::registry('current_customer')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCustomerData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCustomerData());
            Mage::getSingleton('adminhtml/session')->setCustomerData(null);
        } elseif (Mage::registry('current_customer')) {
            $formValues = array_merge($formValues, Mage::registry('current_customer')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
