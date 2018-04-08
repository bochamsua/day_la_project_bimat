<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA edit form tab
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Block_Adminhtml_Meda_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Meda_Block_Adminhtml_Meda_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('meda_');
        $form->setFieldNameSuffix('meda');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'meda_form',
            ['legend' => Mage::helper('bs_meda')->__('MEDA')]
        );

        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_meda/adminhtml_meda_helper_file')
        );

        $currentObj = Mage::registry('current_meda');


        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'customer',
            'select',
            [
                'label'     => Mage::helper('bs_ncr')->__('Customer'),
                'name'      => 'customer',
                'required'  => false,
                'values'    => $customers,
            ]
        );

        $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection');
        $acTypes = $acTypes->toOptionArray();
        array_unshift($acTypes, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'ac_type',
            'select',
            [
                'label'     => Mage::helper('bs_ncr')->__('A/C Type'),
                'name'      => 'ac_type',
                'required'  => false,
                'values'    => $acTypes,
            ]
        );

        $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
        $acRegs->setOrder('reg', 'ASC');
        $acRegs = $acRegs->toOptionArray();
        array_unshift($acRegs, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'ac_reg',
            'select',
            [
                'label'     => Mage::helper('bs_ncr')->__('A/C Reg'),
                'name'      => 'ac_reg',
                'required'  => false,
                'values'    => $acRegs,
            ]
        );



       /* $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_meda')->__('Date of Report'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );*/

        $fieldset->addField(
            'meda_source',
            'file',
            [
                'label' => Mage::helper('bs_meda')->__('Source'),
                'name'  => 'meda_source',

            ]
        );


        $fieldset->addField(
            'meda_no',
            'text',
            [
                'label' => Mage::helper('bs_meda')->__('Report No'),
                'name'  => 'meda_no',

            ]
        );


        $fieldset->addField(
            'event_date',
            'date',
            [
                'label' => Mage::helper('bs_mor')->__('Event Date'),
                'name'  => 'event_date',

                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'consequence',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Consequence'),
                'name'  => 'consequence',

            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Error Description'),
                'name'  => 'description',

            ]
        );


        $fieldset->addField(
            'root_cause',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Root Cause'),
                'name'  => 'root_cause',

            ]
        );

        $fieldset->addField(
            'corrective',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Corrective/Preventive action'),
                'name'  => 'corrective',

            ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Remark Text'),
                'name'  => 'remark_text',

            ]
        );

        $fieldset->addField(
            'revoke',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Revoke/ Suspence Office letter'),
                'name'  => 'revoke',

            ]
        );

        $fieldset->addField(
            'feedback',
            'textarea',
            [
                'label' => Mage::helper('bs_meda')->__('Feedback to reporter'),
                'name'  => 'feedback',

            ]
        );


        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_meda')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_meda')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_meda')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_meda')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getMedaData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getMedaData());
            Mage::getSingleton('adminhtml/session')->setMedaData(null);
        } elseif (Mage::registry('current_meda')) {
            $formValues = array_merge($formValues, Mage::registry('current_meda')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
