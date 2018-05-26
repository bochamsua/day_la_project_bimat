<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data edit form tab
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Block_Adminhtml_Safety_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Safety_Block_Adminhtml_Safety_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('safety_');
        $form->setFieldNameSuffix('safety');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'safety_form',
            ['legend' => Mage::helper('bs_safety')->__('Safety Data')]
        );

        $currentObj = Mage::registry('current_safety');


        $fieldset->addField(
            'safety_type',
            'select',
            [
                'label' => Mage::helper('bs_safety')->__('Type'),
                'name'  => 'safety_type',

            'values'=> Mage::getModel('bs_safety/safety_attribute_source_safetytype')->getAllOptions(false),
            ]
        );

        $fieldset->addField(
            'occur_date',
            'date',
            [
                'label' => Mage::helper('bs_safety')->__('Occurrent Date'),
                'name'  => 'occur_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

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

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_safety')->__('Description'),
                'name'  => 'description',

            ]
        );


        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_safety')->__('Remark'),
                'name'  => 'remark_text',

            ]
        );

        $fieldset->addField(
            'from_text',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('From'),
                'name'  => 'from_text',

            ]
        );

        $depts = Mage::helper('bs_misc/dept')->getDepts(true, false);
        $fieldset->addField(
            'from_dept',
            'select',
            [
                'label'     => Mage::helper('bs_misc')->__('From Maint. Center'),
                'name'      => 'from_dept',
                'required'  => false,
                'values'    => $depts,
            ]
        );


        $fieldset->addField(
            'to_dept',
            'select',
            [
                'label'     => Mage::helper('bs_misc')->__('To Maint. Center'),
                'name'      => 'to_dept',
                'required'  => false,
                'values'    => $depts,
            ]
        );





        $fieldset->addField(
            'related_personel',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Related Personel'),
                'name'  => 'related_personel',

            ]
        );


        $fieldset->addField(
            'event_type',
            'select',
            [
                'label' => Mage::helper('bs_safety')->__('Event Type'),
                'name'  => 'event_type',

                'values'=> Mage::getModel('bs_safety/safety_attribute_source_eventtype')->getAllOptions(false),
            ]
        );

        $fieldset->addField(
            'event_no',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Event No'),
                'name'  => 'event_no',

            ]
        );

        $fieldset->addField(
            'mor',
            'select',
            array(
                'label'  => Mage::helper('bs_safety')->__('MOR/HF'),
                'name'   => 'mor',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_safety')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_safety')->__('No'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'abrupt',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Abrupt'),
                'name'  => 'abrupt',

            ]
        );
        $fieldset->addField(
            'evaluation',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Evaluation'),
                'name'  => 'evaluation',

            ]
        );
        $fieldset->addField(
            'place',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Place'),
                'name'  => 'place',

            ]
        );
        $fieldset->addField(
            'final_action',
            'text',
            [
                'label' => Mage::helper('bs_safety')->__('Final Action'),
                'name'  => 'final_action',

            ]
        );

        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_safety')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_safety')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_safety')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_safety')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getSafetyData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSafetyData());
            Mage::getSingleton('adminhtml/session')->setSafetyData(null);
        } elseif (Mage::registry('current_safety')) {
            $formValues = array_merge($formValues, Mage::registry('current_safety')->getData());
        }

        // define field dependencies
        $htmlIdPrefix = $form->getHtmlIdPrefix();
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap("{$htmlIdPrefix}safety_type", 'safety_type')
            ->addFieldMap("{$htmlIdPrefix}from_dept", 'from_dept')
            ->addFieldMap("{$htmlIdPrefix}to_dept", 'to_dept')
            ->addFieldMap("{$htmlIdPrefix}from_text", 'from_text')
            ->addFieldMap("{$htmlIdPrefix}related_personel", 'related_personel')
            ->addFieldMap("{$htmlIdPrefix}event_type", 'event_type')
            ->addFieldMap("{$htmlIdPrefix}event_no", 'event_no')

            ->addFieldMap("{$htmlIdPrefix}mor", 'mor')
            ->addFieldMap("{$htmlIdPrefix}abrupt", 'abrupt')
            ->addFieldMap("{$htmlIdPrefix}evaluation", 'evaluation')
            ->addFieldMap("{$htmlIdPrefix}place", 'place')
            ->addFieldMap("{$htmlIdPrefix}final_action", 'final_action')

            ->addFieldDependence('from_dept', 'safety_type', ['1','3','4','5'])
            ->addFieldDependence('to_dept', 'safety_type', ['1','2'])
            ->addFieldDependence('from_text', 'safety_type', ['2'])
            ->addFieldDependence('related_personel', 'safety_type', ['3','5'])
            ->addFieldDependence('event_type', 'safety_type', ['4'])
            ->addFieldDependence('event_no', 'safety_type', ['4'])

            ->addFieldDependence('mor', 'safety_type', ['4'])
            ->addFieldDependence('abrupt', 'safety_type', ['4'])
            ->addFieldDependence('evaluation', 'safety_type', ['4'])
            ->addFieldDependence('place', 'safety_type', ['4'])
            ->addFieldDependence('final_action', 'safety_type', ['4'])
        );


        $form->setValues($formValues);

        return parent::_prepareForm();
    }
}
