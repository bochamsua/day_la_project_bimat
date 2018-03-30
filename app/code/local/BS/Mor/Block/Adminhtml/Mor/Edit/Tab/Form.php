<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * MOR edit form tab
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Block_Adminhtml_Mor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Mor_Block_Adminhtml_Mor_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('mor_');
        $form->setFieldNameSuffix('mor');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'mor_form',
            array('legend' => Mage::helper('bs_mor')->__('MOR'))
        );

        $currentObj = Mage::registry('current_mor');

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


        /*$fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_mor')->__('Date of Report'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );*/



        $fieldset->addField(
            'mor_no',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('MOR No'),
                'name'  => 'mor_no',

           )
        );

        $fieldset->addField(
            'ata',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('ATA'),
                'name'  => 'ata',

           )
        );

        $fieldset->addField(
            'occur_date',
            'date',
            array(
                'label' => Mage::helper('bs_mor')->__('Occur Date'),
                'name'  => 'occur_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'flight_no',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Flight No'),
                'name'  => 'flight_no',

           )
        );

        $fieldset->addField(
            'place',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Place'),
                'name'  => 'place',

           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_mor')->__('Description'),
                'name'  => 'description',

           )
        );

        $fieldset->addField(
            'cause',
            'textarea',
            array(
                'label' => Mage::helper('bs_mor')->__('Cause of event'),
                'name'  => 'cause',

           )
        );

        $fieldset->addField(
            'action_take',
            'textarea',
            array(
                'label' => Mage::helper('bs_mor')->__('Action Take'),
                'name'  => 'action_take',

           )
        );

        $fieldset->addField(
            'mor_type',
            'select',
            array(
                'label' => Mage::helper('bs_mor')->__('Type'),
                'name'  => 'mor_type',

            'values'=> Mage::getModel('bs_mor/mor_attribute_source_mortype')->getAllOptions(true),
           )
        );

        $fieldset->addField(
            'mor_filter',
            'select',
            array(
                'label' => Mage::helper('bs_mor')->__('Filter'),
                'name'  => 'mor_filter',

            'values'=> Mage::getModel('bs_mor/mor_attribute_source_morfilter')->getAllOptions(true),
           )
        );

        $fieldset->addField(
            'report',
            'select',
            array(
                'label' => Mage::helper('bs_mor')->__('Report to Manufacturer'),
                'name'  => 'report',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('bs_mor')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('bs_mor')->__('No'),
                ),
            ),
           )
        );



        /*
         * $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_mor')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'close_date',
            'date',
            array(
                'label' => Mage::helper('bs_mor')->__('Close Date'),
                'name'  => 'close_date',

                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            )
        );
        $fieldset->addField(
            'approval_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Approved By'),
                'name'  => 'approval_id',

           )
        );

        $fieldset->addField(
            'mor_status',
            'select',
            array(
                'label' => Mage::helper('bs_mor')->__('Status'),
                'name'  => 'mor_status',

            'values'=> Mage::getModel('bs_mor/mor_attribute_source_morstatus')->getAllOptions(true),
           )
        );



        $fieldset->addField(
            'reject_reason',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Reject Reason'),
                'name'  => 'reject_reason',

           )
        );

        $fieldset->addField(
            'taskgroup_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Task Group'),
                'name'  => 'taskgroup_id',

           )
        );

        $fieldset->addField(
            'task_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Task Id'),
                'name'  => 'task_id',

           )
        );

        $fieldset->addField(
            'subtask_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Subtask'),
                'name'  => 'subtask_id',

           )
        );

        $fieldset->addField(
            'ref_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Ref Id'),
                'name'  => 'ref_id',

           )
        );

        $fieldset->addField(
            'dept_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Dept'),
                'name'  => 'dept_id',

           )
        );

        $fieldset->addField(
            'loc_id',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Location'),
                'name'  => 'loc_id',

           )
        );

        $fieldset->addField(
            'section',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Section'),
                'name'  => 'section',

           )
        );

        $fieldset->addField(
            'region',
            'text',
            array(
                'label' => Mage::helper('bs_mor')->__('Region'),
                'name'  => 'region',

           )
        );*/
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_mor')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_mor')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_mor')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_mor')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getMorData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getMorData());
            Mage::getSingleton('adminhtml/session')->setMorData(null);
        } elseif (Mage::registry('current_mor')) {
            $formValues = array_merge($formValues, Mage::registry('current_mor')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
