<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data edit form tab
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Block_Adminhtml_Cmr_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Cmr_Block_Adminhtml_Cmr_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('cmr_');
        $form->setFieldNameSuffix('cmr');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'cmr_form',
            array('legend' => Mage::helper('bs_cmr')->__('CMR Data'))
        );



        $currentObj = Mage::registry('current_cmr');
        $misc = $this->helper('bs_misc');

        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_cmr')->__('Date of Inspection'),
                'name'  => 'report_date',

                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            )
        );


        $fieldset->addField(
            'code_sqs',
            'text',
            array(
                'label' => Mage::helper('bs_cmr')->__('Code SQS'),
                'name'  => 'code_sqs',

           )
        );

        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionArray();
        $fieldset->addField(
            'dept_id',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('Maint. Center'),
                'name'      => 'dept_id',
                'required'  => false,
                'values'    => $depts,
            )
        );


        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'customer',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('Customer'),
                'name'      => 'customer',
                'required'  => false,
                'values'    => $customers,
            )
        );

        $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection');
        $acTypes = $acTypes->toOptionArray();
		array_unshift($acTypes, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'ac_type',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('A/C Type'),
                'name'      => 'ac_type',
                'required'  => false,
                'values'    => $acTypes,
            )
        );

        $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
        $acRegs->setOrder('reg', 'ASC');
        $acRegs = $acRegs->toOptionArray();
		array_unshift($acRegs, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'ac_reg',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('A/C Reg'),
                'name'      => 'ac_reg',
                'required'  => false,
                'values'    => $acRegs,
            )
        );


        /*$fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_cmr')->__('Due Date'),
                'name'  => 'due_date',

                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            )
        );*/

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_cmr')->__('Description'),
                'name'  => 'description',

            )
        );

        $fieldset->addField(
            'corrective',
            'textarea',
            array(
                'label' => Mage::helper('bs_cmr')->__('Corrective'),
                'name'  => 'corrective',

            )
        );

        $fieldset->addField(
            'preventive',
            'textarea',
            array(
                'label' => Mage::helper('bs_cmr')->__('Preventive'),
                'name'  => 'preventive',

            )
        );

        $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
        $causeGroups = $causeGroups->toOptionArray();
        array_unshift($causeGroups, array('value' => 0, 'label' => 'N/A'));
        $fieldset->addField(
            'ncausegroup_id',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('Cause Group'),
                'name'      => 'ncausegroup_id',
                'required'  => true,
                'values'    => $causeGroups,
            )
        );

        $causes = Mage::getResourceModel('bs_ncause/ncause_collection');
        $causes = $causes->toOptionArray();
        array_unshift($causes, array('value' => 0, 'label' => 'N/A'));
        $fieldset->addField(
            'ncause_id',
            'select',
            array(
                'label'     => Mage::helper('bs_cmr')->__('Cause'),
                'name'      => 'ncause_id',
                'required'  => true,
                'values'    => $causes,
            )
        );


        $fieldset->addField(
            'root_cause',
            'textarea',
            array(
                'label' => Mage::helper('bs_cmr')->__('Root Cause'),
                'name'  => 'root_cause',

            )
        );
        $fieldset->addField(
            'cmr_type',
            'select',
            array(
                'label' => Mage::helper('bs_cmr')->__('Type'),
                'name'  => 'cmr_type',

                'values'=> array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_cmr')->__('1'),
                    ),
                    array(
                        'value' => 2,
                        'label' => Mage::helper('bs_cmr')->__('2'),
                    ),
                    array(
                        'value' => 3,
                        'label' => Mage::helper('bs_cmr')->__('3'),
                    ),
                    array(
                        'value' => 4,
                        'label' => Mage::helper('bs_cmr')->__('4'),
                    ),
                    array(
                        'value' => 5,
                        'label' => Mage::helper('bs_cmr')->__('5'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'repetitive',
            'select',
            array(
                'label' => Mage::helper('bs_cmr')->__('Repetitive'),
                'name'  => 'repetitive',

                'values'=> array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_cmr')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_cmr')->__('No'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            array(
                'label' => Mage::helper('bs_cmr')->__('Remark'),
                'name'  => 'remark_text',

            )
        );

        if($misc->isAdmin($currentObj)){
            $fieldset->addField(
                'cmr_status',
                'select',
                array(
                    'label' => Mage::helper('bs_cmr')->__('Status'),
                    'name'  => 'cmr_status',

                    'values'=> Mage::getModel('bs_cmr/cmr_attribute_source_cmrstatus')->getAllOptions(false),
                )
            );

            $fieldset->addField(
                'close_date',
                'date',
                array(
                    'label' => Mage::helper('bs_cmr')->__('Close Date'),
                    'name'  => 'close_date',
                    'readonly'  => true,
                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),

                )
            );
        }

        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_cmr')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_cmr')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_cmr')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_cmr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCmrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCmrData());
            Mage::getSingleton('adminhtml/session')->setCmrData(null);
        } elseif (Mage::registry('current_cmr')) {
            $formValues = array_merge($formValues, Mage::registry('current_cmr')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
