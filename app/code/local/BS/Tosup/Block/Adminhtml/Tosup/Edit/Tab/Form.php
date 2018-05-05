<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier edit form tab
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Block_Adminhtml_Tosup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Tosup_Block_Adminhtml_Tosup_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('tosup_');
        $form->setFieldNameSuffix('tosup');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'tosup_form',
            ['legend' => Mage::helper('bs_tosup')->__('Tool Supplier')]
        );

        $currentObj = Mage::registry('current_tosup');
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_tosup/adminhtml_tosup_helper_file')
        );

        $fieldset->addField(
            'tosup_no',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('No'),
                'name'  => 'tosup_no',
            'required'  => true,
            'class' => 'required-entry',

           ]
        );

        $fieldset->addField(
            'organization',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('Organization'),
                'name'  => 'organization',

           ]
        );

        $fieldset->addField(
            'address',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('Address'),
                'name'  => 'address',

           ]
        );

        $fieldset->addField(
            'amasis_class',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('Amasis Code Class'),
                'name'  => 'amasis_class',

           ]
        );

        $fieldset->addField(
            'tosup_source',
            'file',
            [
                'label' => Mage::helper('bs_tosup')->__('Source'),
                'name'  => 'tosup_source',

           ]
        );

        $fieldset->addField(
            'issue_date',
            'date',
            [
                'label' => Mage::helper('bs_tosup')->__('Issue Date'),
                'name'  => 'issue_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'expire_date',
            'date',
            [
                'label' => Mage::helper('bs_tosup')->__('Expire Date'),
                'name'  => 'expire_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'approved_scope',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('Approved Scope'),
                'name'  => 'approved_scope',

           ]
        );

        $fieldset->addField(
            'remaining',
            'text',
            [
                'label' => Mage::helper('bs_tosup')->__('Remaining'),
                'name'  => 'remaining',

           ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_tosup')->__('Remark'),
                'name'  => 'remark_text',

           ]
        );



        /*$fieldset->addField(
            'tosup_status',
            'select',
            [
                'label' => Mage::helper('bs_tosup')->__('Status'),
                'name'  => 'tosup_status',

            'values'=> Mage::getModel('bs_tosup/tosup_attribute_source_supstatus')->getAllOptions(true),
           ]
        );*/


        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_tosup')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_tosup')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_tosup')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_tosup')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getTosupData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getTosupData());
            Mage::getSingleton('adminhtml/session')->setTosupData(null);
        } elseif (Mage::registry('current_tosup')) {
            $formValues = array_merge($formValues, Mage::registry('current_tosup')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
