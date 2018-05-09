<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr edit form tab
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Block_Adminhtml_Ncr_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Ncr_Block_Adminhtml_Ncr_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('ncr_');
        $form->setFieldNameSuffix('ncr');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'ncr_form',
            ['legend' => Mage::helper('bs_ncr')->__('NCR')]
        );

        $refId = $this->getRequest()->getParam('ref_id');
        $taskId = $this->getRequest()->getParam('task_id');
        $refType = $this->getRequest()->getParam('ref_type');

        $new = true;


        $currentObj = Mage::registry('current_ncr');
        $misc = $this->helper('bs_misc');

        if($currentObj && $currentObj->getId()){
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
            $taskId = $currentObj->getTaskId();
        }

        $fieldset->addField(
            'ref_id',
            'hidden',
            [
                'label' => Mage::helper('bs_ncr')->__('ref_id'),
                'name'  => 'ref_id',


            ]
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            [
                'label' => Mage::helper('bs_ncr')->__('ref_type'),
                'name'  => 'ref_type',


            ]
        );


	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ncr')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );


        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_ncr/adminhtml_ncr_helper_file')
        );



        $disable = false;
        if($misc->isManager($currentObj) && $currentObj->getId() && !$misc->isOwner($currentObj)){
            $disable = true;
        }

        if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                [
                    'label' => Mage::helper('bs_ncr')->__('Source Code'),
                    'name'  => 'task_id',
                    'values'=> $tasks,
                    'disabled'  => $disable
                ]
            );

            $subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
            $subtasks->addFieldToFilter('task_id', $taskId);
            $subtasks = $subtasks->toOptionArray();
            array_unshift($subtasks, ['value'=>'0', 'label'=>'N/A']);

            $fieldset->addField(
                'subtask_id',
                'select',
                [
                    'label' => Mage::helper('bs_ncr')->__('Source'),
                    'name'  => 'subtask_id',
                    'values'=> $subtasks,
                    'disabled'  => $disable
                ]
            );
        }else {
            $label = 'Other';
            if($refType){
                $label = ucfirst($refType);
            }
            $fieldset->addField(
                'task_id',
                'select',
                [
                    'label' => Mage::helper('bs_ncr')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                ]
            );

            $fieldset->addField(
                'source_other',
                'text',
                [
                    'label' => Mage::helper('bs_ncr')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                ]
            );
        }



	    $fieldset->addField(
		    'repetitive',
		    'select',
		    [
			    'label'  => Mage::helper('bs_ncr')->__('Repetitive'),
			    'name'   => 'repetitive',
			    'values' => [
				    [
					    'value' => 1,
					    'label' => Mage::helper('bs_ncr')->__('Yes'),
                    ],
				    [
					    'value' => 0,
					    'label' => Mage::helper('bs_ncr')->__('No'),
                    ],
                ],
			    'disabled'  => $disable
            ]
	    );

        $fieldset->addField(
            'ncr_source',
            'file',
            [
                'label' => Mage::helper('bs_ncr')->__('Source'),
                'name'  => 'ncr_source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                'disabled'  => $disable

            ]
        );


	    $fieldset->addField(
		    'report_date',
		    'date',
		    [
			    'label' => Mage::helper('bs_ncr')->__('Report Date'),
			    'name'  => 'report_date',
			    'image' => $this->getSkinUrl('images/grid-cal.gif'),
			    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),


            ]
	    );


        $fieldset->addField(
            'ref_doc',
            'text',
            [
                'label' => Mage::helper('bs_ncr')->__('REF Doc'),
                'name'  => 'ref_doc',
                'disabled'  => $disable


            ]
        );

	    $customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
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

	    $locs = Mage::getResourceModel('bs_misc/location_collection');
	    $locs = $locs->toOptionArray();
		array_unshift($locs, ['value' => 0, 'label' => 'N/A']);
	    array_unshift($locs, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'loc_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_misc')->__('Location'),
			    'name'      => 'loc_id',
			    'required'  => false,
			    'values'    => $locs,
            ]
	    );

        /*$fieldset->addField(
            'ac',
            'text',
            array(
                'label' => Mage::helper('bs_ncr')->__('A/C'),
                'name'  => 'ac',
            'required'  => true,
            'class' => 'required-entry',
                'disabled'  => $disable

           )
        );*/

        $fieldset->addField(
            'ncr_type',
            'select',
            [
                'label' => Mage::helper('bs_ncr')->__('Type'),
                'name'  => 'ncr_type',

            'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_ncrtype')->getAllOptions(false),
                'disabled'  => $disable
            ]
        );

	    $fieldset->addField(
		    'error_type',
		    'select',
		    [
			    'label' => Mage::helper('bs_ncr')->__('Error Type'),
			    'name'  => 'error_type',

			    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_errortype')->getAllOptions(false),
			    'disabled'  => $disable
            ]
	    );

        $fieldset->addField(
            'point',
            'text',
            [
                'label' => Mage::helper('bs_ncr')->__('Point'),
                'name'  => 'point',
                'disabled'  => $disable


            ]
        );


        $fieldset->addField(
		    'short_desc',
		    'text',
		    [
			    'label' => Mage::helper('bs_ncr')->__('Short Description'),
			    'name'  => 'short_desc',
			    'disabled'  => $disable,
			    'maxlength' => 75


            ]
	    );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_ncr')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable,


            ]
        );

        $fieldset->addField(
            'due_date',
            'date',
            [
                'label' => Mage::helper('bs_ncr')->__('Due Date'),
                'name'  => 'due_date',
                'readonly'  => true,
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
            ]
        );



	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'ncr_status',
			    'select',
			    [
				    'label' => Mage::helper('bs_ncr')->__('Status'),
				    'name'  => 'ncr_status',

				    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_ncrstatus')->getAllOptions(false),
                ]
		    );

		    /*$fieldset->addField(
			    'close_date',
			    'date',
			    array(
				    'label' => Mage::helper('bs_ncr')->__('Close Date'),
				    'name'  => 'close_date',
				    'readonly'  => true,
				    'image' => $this->getSkinUrl('images/grid-cal.gif'),
				    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),

			    )
		    );*/
	    }


        if(in_array($currentObj->getNcrStatus(), [2,3,4,5,6])){// && $currentObj->getAccept() == 1

            $fieldset->addField(
                'remark',
                'file',
                [
                    'label' => Mage::helper('bs_ncr')->__('Proof of Close'),
                    'name'  => 'remark',
                    'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),


                ]
            );

	        $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
	        $causeGroups = $causeGroups->toOptionArray();
	        array_unshift($causeGroups, ['value' => 0, 'label' => 'N/A']);
	        $fieldset->addField(
		        'ncausegroup_id',
		        'select',
		        [
			        'label'     => Mage::helper('bs_ncr')->__('Cause Group'),
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
			        'label'     => Mage::helper('bs_ncr')->__('Cause'),
			        'name'      => 'ncause_id',
			        'required'  => true,
			        'values'    => $causes,
                ]
	        );

            $fieldset->addField(
                'close_date',
                'date',
                [
                    'label' => Mage::helper('bs_ncr')->__('Close Date'),
                    'name'  => 'close_date',

                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                    'disabled'  => $disable
                ]
            );
        }

	    $fieldset->addField(
		    'remark_text',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ncr')->__('Remark'),
			    'name'  => 'remark_text',
			    'disabled'  => $disable,
			    'config' => $wysiwygConfig,

            ]
	    );




        $fieldset->addField(
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
        );



        $bypass = Mage::getSingleton('admin/session')->isAllowed("bs_work/ncr/accept");
        if($misc->canAcceptReject($currentObj, null, [], $bypass)){//manager

            $fieldset->addField(
                'reject_reason',
                'text',
                [
                    'label' => Mage::helper('bs_ncr')->__('Reject Reason'),
                    'name'  => 'reject_reason',
                ]
            );
        }
        $fieldset->addField(
            'self_remark',
            'textarea',
            [
                'label' => Mage::helper('bs_ncr')->__('Note'),
                'name'  => 'self_remark'

            ]
        );


        $formValues = Mage::registry('current_ncr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getNcrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNcrData());
            Mage::getSingleton('adminhtml/session')->setNcrData(null);
        } elseif (Mage::registry('current_ncr')) {
            $formValues = array_merge($formValues, Mage::registry('current_ncr')->getData());
        }

        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);

        $idPrefix = $form->getHtmlIdPrefix();
	    /*$this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
	                                       ->addFieldMap($idPrefix.'short_desc', 'short_desc')
	                                       ->addFieldMap($idPrefix.'description', 'description')
	                                       ->addFieldDependence('description', 'short_desc', array('isnull' => false))

	    );*/

        return parent::_prepareForm();
    }
}
