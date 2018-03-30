<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA edit form tab
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Block_Adminhtml_Hira_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Hira_Block_Adminhtml_Hira_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('hira_');
        $form->setFieldNameSuffix('hira');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'hira_form',
            array('legend' => Mage::helper('bs_hira')->__('HIRA'))
        );

        $currentObj = Mage::registry('current_hira');
        $misc = $this->helper('bs_misc');

        $disabled = false;
        if($currentObj->getHiraStatus() == 1){
            $disabled = true;
        }

        $fieldset->addField(
            'generic_hazzard',
            'textarea',
            array(
                'label' => Mage::helper('bs_hira')->__('Generic Hazzard'),
                'name'  => 'generic_hazzard',
                'disabled'  => $disabled

           )
        );


        /*$fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_hira')->__('Date of Report'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );*/

        $fieldset->addField(
            'specify_component',
            'textarea',
            array(
                'label' => Mage::helper('bs_hira')->__('Specify component of hazzard'),
                'name'  => 'specify_component',
                'disabled'  => $disabled

           )
        );

        $fieldset->addField(
            'associated_risk',
            'textarea',
            array(
                'label' => Mage::helper('bs_hira')->__('Associated risk of hazzard'),
                'name'  => 'associated_risk',
                'disabled'  => $disabled

           )
        );

        /*$fieldset->addField(
            'hira_type',
            'select',
            array(
                'label' => Mage::helper('bs_hira')->__('Type'),
                'name'  => 'hira_type',

            'values'=> Mage::getModel('bs_hira/hira_attribute_source_hiratype')->getAllOptions(true),
           )
        );*/

        $fieldset->addField(
            'probability',
            'select',
            array(
                'label' => Mage::helper('bs_hira')->__('Probability of occurrent'),
                'name'  => 'probability',
                'disabled'  => $disabled,

                'values'=> Mage::getModel('bs_hira/hira_attribute_source_probability')->getAllOptions(true),
           )
        );

        $fieldset->addField(
            'severity',
            'select',
            array(
                'label' => Mage::helper('bs_hira')->__('Severity of occurrent'),
                'name'  => 'severity',

                'values'=> Mage::getModel('bs_hira/hira_attribute_source_severity')->getAllOptions(true),
                'disabled'  => $disabled
           )
        );

        if(in_array($currentObj->getHiraStatus(), [1,2])){
            $fieldset->addField(
                'mitigation',
                'textarea',
                array(
                    'label' => Mage::helper('bs_hira')->__('Mitigation'),
                    'name'  => 'mitigation',

                )
            );

            $fieldset->addField(
                'hira_code',
                'textarea',
                array(
                    'label' => Mage::helper('bs_hira')->__('HIRA Code'),
                    'name'  => 'hira_code',

                )
            );

            $fieldset->addField(
                'probability_after',
                'select',
                array(
                    'label' => Mage::helper('bs_hira')->__('Probability after mitigation'),
                    'name'  => 'probability_after',

                    'values'=> Mage::getModel('bs_hira/hira_attribute_source_probabilityafter')->getAllOptions(true),
                )
            );

            $fieldset->addField(
                'severity_after',
                'select',
                array(
                    'label' => Mage::helper('bs_hira')->__('Severity after mitigation'),
                    'name'  => 'severity_after',

                    'values'=> Mage::getModel('bs_hira/hira_attribute_source_severityafter')->getAllOptions(true),
                )
            );

            $fieldset->addField(
                'follow_up',
                'textarea',
                array(
                    'label' => Mage::helper('bs_hira')->__('Follow up'),
                    'name'  => 'follow_up',

                )
            );
        }


       /* $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_hira')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'approval_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Approved By'),
                'name'  => 'approval_id',

           )
        );

        $fieldset->addField(
            'hira_status',
            'select',
            array(
                'label' => Mage::helper('bs_hira')->__('Status'),
                'name'  => 'hira_status',

            'values'=> Mage::getModel('bs_hira/hira_attribute_source_hirastatus')->getAllOptions(true),
           )
        );

        $fieldset->addField(
            'close_date',
            'date',
            array(
                'label' => Mage::helper('bs_hira')->__('Close Date'),
                'name'  => 'close_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'reject_reason',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Reject Reason'),
                'name'  => 'reject_reason',

           )
        );

        $fieldset->addField(
            'taskgroup_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Task Group'),
                'name'  => 'taskgroup_id',

           )
        );

        $fieldset->addField(
            'task_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Task Id'),
                'name'  => 'task_id',

           )
        );

        $fieldset->addField(
            'subtask_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Subtask'),
                'name'  => 'subtask_id',

           )
        );

        $fieldset->addField(
            'ref_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Ref Id'),
                'name'  => 'ref_id',

           )
        );

        $fieldset->addField(
            'dept_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Dept'),
                'name'  => 'dept_id',

           )
        );

        $fieldset->addField(
            'loc_id',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Location'),
                'name'  => 'loc_id',

           )
        );

        $fieldset->addField(
            'section',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Section'),
                'name'  => 'section',

           )
        );

        $fieldset->addField(
            'region',
            'text',
            array(
                'label' => Mage::helper('bs_hira')->__('Region'),
                'name'  => 'region',

           )
        );*/
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_hira')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_hira')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_hira')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_hira')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getHiraData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getHiraData());
            Mage::getSingleton('adminhtml/session')->setHiraData(null);
        } elseif (Mage::registry('current_hira')) {
            $formValues = array_merge($formValues, Mage::registry('current_hira')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
