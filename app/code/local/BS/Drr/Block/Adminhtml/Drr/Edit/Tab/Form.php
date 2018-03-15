<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr edit form tab
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Block_Adminhtml_Drr_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Drr_Block_Adminhtml_Drr_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('drr_');
        $form->setFieldNameSuffix('drr');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'drr_form',
            array('legend' => Mage::helper('bs_drr')->__('Drr'))
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_drr/adminhtml_drr_helper_file')
        );



        $refId = $this->getRequest()->getParam('ref_id');
        $taskId = $this->getRequest()->getParam('task_id');
        $refType = $this->getRequest()->getParam('ref_type');

        $new = true;

        $currentObj = Mage::registry('current_drr');
        if($currentObj && $currentObj->getId()){
            $new = false;
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
            $taskId = $currentObj->getTaskId();
        }

        $disable = false;
        $misc = $this->helper('bs_misc');
        if($misc->isManager($currentObj) && $currentObj->getId()){
            $disable = true;
        }

        $fieldset->addField(
            'ref_id',
            'hidden',
            array(
                'label' => Mage::helper('bs_drr')->__('ref_id'),
                'name'  => 'ref_id',


            )
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            array(
                'label' => Mage::helper('bs_drr')->__('ref_type'),
                'name'  => 'ref_type',


            )
        );

        if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                array(
                    'label' => Mage::helper('bs_drr')->__('Survey Code'),
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
                    'label' => Mage::helper('bs_drr')->__('Source'),
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
                    'label' => Mage::helper('bs_drr')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                )
            );

            $fieldset->addField(
                'source_other',
                'text',
                array(
                    'label' => Mage::helper('bs_drr')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                )
            );
        }

        $fieldset->addField(
            'drr_source',
            'file',
            array(
                'label' => Mage::helper('bs_drr')->__('Source'),
                'name'  => 'drr_source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                'disabled'  => $disable

           )
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_drr')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
		    )
	    );

        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_drr')->__('Report Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
           )
        );


	    $customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'customer',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_drr')->__('Customer'),
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
			    'label'     => Mage::helper('bs_drr')->__('A/C Type'),
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
			    'label'     => Mage::helper('bs_drr')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );

	    $fieldset->addField(
		    'flight_no',
		    'text',
		    array(
			    'label' => Mage::helper('bs_drr')->__('Flight No'),
			    'name'  => 'flight_no',
			    'disabled'  => $disable

		    )
	    );

	    /*$fieldset->addField(
		    'check',
		    'text',
		    array(
			    'label' => Mage::helper('bs_drr')->__('Check'),
			    'name'  => 'check',
			    'disabled'  => $disable

		    )
	    );

	    $fieldset->addField(
		    'wp',
		    'text',
		    array(
			    'label' => Mage::helper('bs_drr')->__('Work Pack'),
			    'name'  => 'wp',
			    'disabled'  => $disable

		    )
	    );*/





       $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_drr')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable,
	            'config'    => $wysiwygConfig

           )
        );

        $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_drr')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
           )
        );



        /*$fieldset->addField(
            'drr_status',
            'select',
            array(
                'label' => Mage::helper('bs_drr')->__('Status'),
                'name'  => 'drr_status',

            'values'=> Mage::getModel('bs_drr/drr_attribute_source_drrstatus')->getAllOptions(true),
                'disabled'  => $disable
           )
        );*/


	    $disableProof = false;
	    if(!in_array($currentObj->getDrrStatus(), [1,4])){//closed/late closed, disable but still allow admin edit
            $disableProof = true;
            if($misc->isAdmin($currentObj)){
                $disableProof = false;
            }
	    }

        if(in_array($currentObj->getDrrStatus(), [1,2,3,4])) {//hide in draft status - 0
            $fieldset->addField(
                'remark',
                'file',
                array(
                    'label' => Mage::helper('bs_drr')->__('Proof of Close'),
                    'name'  => 'remark',
                    'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                    'disabled'  => $disableProof

                )
            );

            /*$causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
            $causeGroups = $causeGroups->toOptionArray();
            array_unshift($causeGroups, array('value' => 0, 'label' => 'N/A'));
            $fieldset->addField(
                'ncausegroup_id',
                'select',
                array(
                    'label'     => Mage::helper('bs_drr')->__('Cause Group'),
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
                    'label'     => Mage::helper('bs_drr')->__('Cause'),
                    'name'      => 'ncause_id',
                    'required'  => true,
                    'values'    => $causes,
                )
            );*/




            $fieldset->addField(
                'close_date',
                'date',
                array(
                    'label' => Mage::helper('bs_drr')->__('Close Date'),
                    'name'  => 'close_date',

                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    //'disabled'  => $disable
                )
            );

        }








	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'drr_status',
			    'select',
			    array(
				    'label' => Mage::helper('bs_drr')->__('Status'),
				    'name'  => 'drr_status',

				    'values'=> Mage::getModel('bs_drr/drr_attribute_source_drrstatus')->getAllOptions(false),
			    )
		    );

		    /*$fieldset->addField(
			    'close_date',
			    'date',
			    array(
				    'label' => Mage::helper('bs_drr')->__('Close Date'),
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
            array(
                'label' => Mage::helper('bs_drr')->__('Note'),
                'name'  => 'self_remark'

            )
        );





        $formValues = Mage::registry('current_drr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getDrrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getDrrData());
            Mage::getSingleton('adminhtml/session')->setDrrData(null);
        } elseif (Mage::registry('current_drr')) {
            $formValues = array_merge($formValues, Mage::registry('current_drr')->getData());
        }
        $formValues = array_merge($formValues, array(
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ));

        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
