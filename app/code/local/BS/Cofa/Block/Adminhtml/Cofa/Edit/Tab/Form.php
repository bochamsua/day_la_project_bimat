<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data edit form tab
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Block_Adminhtml_Cofa_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('cofa_');
        $form->setFieldNameSuffix('cofa');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'cofa_form',
            array('legend' => Mage::helper('bs_cofa')->__('CoA Data'))
        );

        $fieldset->addField(
            'ref_no',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Reference No'),
                'name'  => 'ref_no',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'code_sqs',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Code SQS'),
                'name'  => 'code_sqs',

           )
        );

        $fieldset->addField(
            'ins_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Inspector'),
                'name'  => 'ins_id',

           )
        );

        $fieldset->addField(
            'dept_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Department'),
                'name'  => 'dept_id',

           )
        );

        $fieldset->addField(
            'loc_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Location'),
                'name'  => 'loc_id',

           )
        );

        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_cofa')->__('Date of Inspection'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_cofa')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'close_date',
            'date',
            array(
                'label' => Mage::helper('bs_cofa')->__('Close Date'),
                'name'  => 'close_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'root_cause',
            'textarea',
            array(
                'label' => Mage::helper('bs_cofa')->__('Root Cause'),
                'name'  => 'root_cause',

           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_cofa')->__('Description'),
                'name'  => 'description',

           )
        );

        $fieldset->addField(
            'corrective',
            'textarea',
            array(
                'label' => Mage::helper('bs_cofa')->__('Corrective'),
                'name'  => 'corrective',

           )
        );

        $fieldset->addField(
            'preventive',
            'textarea',
            array(
                'label' => Mage::helper('bs_cofa')->__('Preventive'),
                'name'  => 'preventive',

           )
        );

        $fieldset->addField(
            'repetitive',
            'select',
            array(
                'label' => Mage::helper('bs_cofa')->__('Repetitive'),
                'name'  => 'repetitive',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('bs_cofa')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('bs_cofa')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'cofa_type',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Type'),
                'name'  => 'cofa_type',

           )
        );

        $fieldset->addField(
            'cofa_status',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Status'),
                'name'  => 'cofa_status',

           )
        );


        $fieldset->addField(
            'task_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Survey Code'),
                'name'  => 'task_id',

           )
        );

        $fieldset->addField(
            'customer',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Customer'),
                'name'  => 'customer',

           )
        );

        $fieldset->addField(
            'ac_type',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('AC Type'),
                'name'  => 'ac_type',

           )
        );

        $fieldset->addField(
            'ac_reg',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('AC Reg'),
                'name'  => 'ac_reg',

           )
        );

        $fieldset->addField(
            'ncausegroup_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Root Cause Code'),
                'name'  => 'ncausegroup_id',

           )
        );

        $fieldset->addField(
            'ncause_id',
            'text',
            array(
                'label' => Mage::helper('bs_cofa')->__('Root Cause Sub Code'),
                'name'  => 'ncause_id',

           )
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            array(
                'label' => Mage::helper('bs_cofa')->__('Remark'),
                'name'  => 'remark_text',

           )
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_cofa')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_cofa')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_cofa')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_cofa')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCofaData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCofaData());
            Mage::getSingleton('adminhtml/session')->setCofaData(null);
        } elseif (Mage::registry('current_cofa')) {
            $formValues = array_merge($formValues, Mage::registry('current_cofa')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
