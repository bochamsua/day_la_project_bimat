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
            array('legend' => Mage::helper('bs_safety')->__('Safety Data'))
        );

        $currentObj = Mage::registry('current_safety');


        $fieldset->addField(
            'safety_type',
            'select',
            array(
                'label' => Mage::helper('bs_safety')->__('Type'),
                'name'  => 'safety_type',

            'values'=> Mage::getModel('bs_safety/safety_attribute_source_safetytype')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'occur_date',
            'date',
            array(
                'label' => Mage::helper('bs_safety')->__('Occurrent Date'),
                'name'  => 'occur_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        array_unshift($customers, array('value' => 0, 'label' => 'N/A'));
        $fieldset->addField(
            'customer',
            'select',
            array(
                'label'     => Mage::helper('bs_ncr')->__('Customer'),
                'name'      => 'customer',
                'required'  => false,
                'values'    => $customers,
            )
        );

        $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection');
        $acTypes = $acTypes->toOptionArray();
        array_unshift($acTypes, array('value' => 0, 'label' => 'N/A'));
        $fieldset->addField(
            'ac_type',
            'select',
            array(
                'label'     => Mage::helper('bs_ncr')->__('A/C Type'),
                'name'      => 'ac_type',
                'required'  => false,
                'values'    => $acTypes,
            )
        );

        $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
        $acRegs->setOrder('reg', 'ASC');
        $acRegs = $acRegs->toOptionArray();
        array_unshift($acRegs, array('value' => 0, 'label' => 'N/A'));
        $fieldset->addField(
            'ac_reg',
            'select',
            array(
                'label'     => Mage::helper('bs_ncr')->__('A/C Reg'),
                'name'      => 'ac_reg',
                'required'  => false,
                'values'    => $acRegs,
            )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_safety')->__('Description'),
                'name'  => 'description',

           )
        );


        $fieldset->addField(
            'remark_text',
            'textarea',
            array(
                'label' => Mage::helper('bs_safety')->__('Remark'),
                'name'  => 'remark_text',

           )
        );

        $fieldset->addField(
            'from_text',
            'text',
            array(
                'label' => Mage::helper('bs_safety')->__('From'),
                'name'  => 'from_text',

            )
        );

        $depts = Mage::helper('bs_misc/dept')->getDepts(true, false);
        $fieldset->addField(
            'from_dept',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('From Maint. Center'),
                'name'      => 'from_dept',
                'required'  => false,
                'values'    => $depts,
            )
        );


        $fieldset->addField(
            'to_dept',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('To Maint. Center'),
                'name'      => 'to_dept',
                'required'  => false,
                'values'    => $depts,
            )
        );





        $fieldset->addField(
            'related_personel',
            'text',
            array(
                'label' => Mage::helper('bs_safety')->__('Related Personel'),
                'name'  => 'related_personel',

           )
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
            $formValues = array();
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
            ->addFieldDependence('from_dept', 'safety_type', ['1','3','4'])
            ->addFieldDependence('to_dept', 'safety_type', ['1','2'])
            ->addFieldDependence('from_text', 'safety_type', ['2'])
            ->addFieldDependence('related_personel', 'safety_type', ['3','4'])
        );


        $form->setValues($formValues);

        return parent::_prepareForm();
    }
}
