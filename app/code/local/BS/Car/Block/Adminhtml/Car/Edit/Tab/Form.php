<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car edit form tab
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Block_Adminhtml_Car_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Car_Block_Adminhtml_Car_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('car_');
        $form->setFieldNameSuffix('car');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'car_form',
            ['legend' => Mage::helper('bs_car')->__('Car')]
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_car/adminhtml_car_helper_file')
        );

        //$taskGroupId = $this->getRequest()->getParam('taskgroup_id');
        $refId = $this->getRequest()->getParam('ref_id');
        $taskId = $this->getRequest()->getParam('task_id');
        $refType = $this->getRequest()->getParam('ref_type');

        $new = true;

        $currentObj = Mage::registry('current_car');
        if($currentObj && $currentObj->getId()){
            $new = false;
            //$taskGroupId = $currentObj->getTaskgroupId();
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
            $taskId = $currentObj->getTaskId();
        }

        $disable = false;
        $misc = $this->helper('bs_misc');
        if($misc->isManager($currentObj) && $currentObj->getId()){
            //$disable = true;
        }

        $fieldset->addField(
            'ref_id',
            'hidden',
            [
                'label' => Mage::helper('bs_car')->__('ref_id'),
                'name'  => 'ref_id',


            ]
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            [
                'label' => Mage::helper('bs_car')->__('ref_type'),
                'name'  => 'ref_type',


            ]
        );

        /*if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                array(
                    'label' => Mage::helper('bs_car')->__('Survey Code'),
                    'name'  => 'task_id',
                    'values'=> $tasks,
                    'disabled'  => $disable
                )
            );

            $subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
            $subtasks->addFieldToFilter('task_id', $taskId);
            $subtasks = $subtasks->toOptionArray();
            array_unshift($subtasks, array('value'=>'0', 'label'=>'N/A'));

            $fieldset->addField(
                'subtask_id',
                'select',
                array(
                    'label' => Mage::helper('bs_car')->__('Source'),
                    'name'  => 'subtask_id',
                    'values'=> $subtasks,
                    'disabled'  => $disable
                )
            );
        }else {
            $label = 'Other';
            if($refType){
                $label = ucfirst($refType);
            }
            $fieldset->addField(
                'task_id',
                'select',
                array(
                    'label' => Mage::helper('bs_car')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                )
            );
            $fieldset->addField(
                'source_other',
                'text',
                array(
                    'label' => Mage::helper('bs_car')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                )
            );
        }*/

        $fieldset->addField(
            'car_no',
            'text',
            [
                'label' => Mage::helper('bs_car')->__('CAR No'),
                'name'  => 'car_no',

            ]
        );

        $fieldset->addField(
            'car_source',
            'file',
            [
                'label' => Mage::helper('bs_car')->__('Source'),
                'name'  => 'car_source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                //'disabled'  => $disable

            ]
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_car')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_car')->__('Report Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
            ]
        );


	    /*$customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'customer',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_car')->__('Customer'),
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
			    'label'     => Mage::helper('bs_car')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
		    )
	    );

	    $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
	    $acRegs = $acRegs->toOptionArray();
		array_unshift($acRegs, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'ac_reg',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_car')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );*/

	    $fieldset->addField(
		    'audit_report_ref',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_car')->__('Audit Report Ref'),
			    'name'  => 'audit_report_ref',
			    'disabled'  => $disable

            ]
	    );

        $fieldset->addField(
            'level',
            'select',
            [
                'label' => Mage::helper('bs_car')->__('Level'),
                'name'  => 'level',

                'values'=> Mage::getModel('bs_car/car_attribute_source_level')->getAllOptions(false),
                'disabled'  => $disable
            ]
        );

	    $fieldset->addField(
		    'nc_cause_text',
		    'text',
		    [
			    'label' => Mage::helper('bs_car')->__('NC Cause'),
			    'name'  => 'nc_cause_text',
			    'disabled'  => $disable

            ]
	    );





       $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_car')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable,
	            'config'    => $wysiwygConfig

            ]
        );


        $fieldset->addField(
            'root_cause',
            'textarea',
            [
                'label' => Mage::helper('bs_car')->__('Root Cause'),
                'name'  => 'root_cause',

            ]
        );

        $fieldset->addField(
            'preventive_action',
            'textarea',
            [
                'label' => Mage::helper('bs_car')->__('Preventive Action'),
                'name'  => 'preventive_action',

            ]
        );

        $fieldset->addField(
            'follow_up',
            'textarea',
            [
                'label' => Mage::helper('bs_car')->__('Follow Up and Closure'),
                'name'  => 'follow_up',

            ]
        );



        $fieldset->addField(
            'due_date',
            'date',
            [
                'label' => Mage::helper('bs_car')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
            ]
        );

        $fieldset->addField(
            'repetitive',
            'select',
            [
                'label'  => Mage::helper('bs_hr')->__('Repetitive'),
                'name'   => 'repetitive',
                'values' => [
                    [
                        'value' => 1,
                        'label' => Mage::helper('bs_hr')->__('Yes'),
                    ],
                    [
                        'value' => 0,
                        'label' => Mage::helper('bs_hr')->__('No'),
                    ],
                ],
            ]
        );


        /*$fieldset->addField(
            'is_coa',
            'select',
            array(
                'label'  => Mage::helper('bs_coa')->__('Issue Corrective Action?'),
                'name'   => 'is_coa',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_coa')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_coa')->__('No'),
                    ),
                ),
            )
        );*/


        $disableProof = false;
        if(!in_array($currentObj->getCarStatus(), [1,4])){//closed/late closed, disable but still allow admin edit
            $disableProof = true;
            if($misc->isAdmin($currentObj)){
                $disableProof = false;
            }
        }

        if($currentObj->getCarStatus() > 0){//hide in draft status - 0
            $fieldset->addField(
                'remark',
                'file',
                [
                    'label' => Mage::helper('bs_car')->__('Proof of Close'),
                    'name'  => 'remark',
                    'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                    'disabled'  => $disableProof

                ]
            );

            $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
            $causeGroups = $causeGroups->toOptionArray();
            array_unshift($causeGroups, ['value' => 0, 'label' => 'N/A']);
            $fieldset->addField(
                'ncausegroup_id',
                'select',
                [
                    'label'     => Mage::helper('bs_car')->__('Cause Group'),
                    'name'      => 'ncausegroup_id',
                    'required'  => true,
                    'values'    => $causeGroups,
                ]
            );

            $causes = Mage::getResourceModel('bs_ncause/ncause_collection');
            $causes = $causes->toOptionArray();
            array_unshift($causes, ['value' => 0, 'label' => 'N/A']);
            $fieldset->addField(
                'ncause_id',
                'select',
                [
                    'label'     => Mage::helper('bs_car')->__('Cause'),
                    'name'      => 'ncause_id',
                    'required'  => true,
                    'values'    => $causes,
                ]
            );




            $fieldset->addField(
                'res_date',
                'date',
                [
                    'label' => Mage::helper('bs_car')->__('Res. Date'),
                    'name'  => 'res_date',

                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    'disabled'  => $disable
                ]
            );

            $fieldset->addField(
                'error_type',
                'select',
                [
                    'label' => Mage::helper('bs_car')->__('Error Type'),
                    'name'  => 'error_type',
                    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_errortype')->getAllOptions(false),
                ]
            );
        }






	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'car_status',
			    'select',
			    [
				    'label' => Mage::helper('bs_car')->__('Status'),
				    'name'  => 'car_status',

				    'values'=> Mage::getModel('bs_car/car_attribute_source_carstatus')->getAllOptions(false),
                ]
		    );

		    /*$fieldset->addField(
			    'close_date',
			    'date',
			    array(
				    'label' => Mage::helper('bs_car')->__('Close Date'),
				    'name'  => 'close_date',
				    'readonly'  => true,
				    'image' => $this->getSkinUrl('images/grid-cal.gif'),
				    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),

			    )
		    );*/
	    }



        $fieldset->addField(
            'self_remark',
            'textarea',
            [
                'label' => Mage::helper('bs_car')->__('Note'),
                'name'  => 'self_remark'

            ]
        );


        $formValues = Mage::registry('current_car')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getCarData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCarData());
            Mage::getSingleton('adminhtml/session')->setCarData(null);
        } elseif (Mage::registry('current_car')) {
            $formValues = array_merge($formValues, Mage::registry('current_car')->getData());
        }

        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
