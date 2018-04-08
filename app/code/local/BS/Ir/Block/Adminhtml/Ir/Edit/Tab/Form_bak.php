<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir edit form tab
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Block_Adminhtml_Ir_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Ir_Block_Adminhtml_Ir_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('ir_');
        $form->setFieldNameSuffix('ir');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'ir_form',
            ['legend' => Mage::helper('bs_ir')->__('Ir')]
        );

	    $fieldset->addType(
		    'file',
		    Mage::getConfig()->getBlockClassName('bs_ir/adminhtml_ir_helper_file')
	    );

        $refId = $this->getRequest()->getParam('ref_id');
        $taskId = $this->getRequest()->getParam('task_id');
        $refType = $this->getRequest()->getParam('ref_type');

        $currentObj = Mage::registry('current_ir');
        if($currentObj && $currentObj->getId()){
            $new = false;
            //$taskGroupId = $currentObj->getTaskgroupId();
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
            $taskId = $currentObj->getTaskId();
        }

        $misc = $this->helper('bs_misc');

        $disable = false;
        if($misc->isManager($currentObj) && $currentObj->getId()){
            $disable = true;
        }

        $fieldset->addField(
            'ref_id',
            'hidden',
            [
                'label' => Mage::helper('bs_ir')->__('ref_id'),
                'name'  => 'ref_id',


            ]
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            [
                'label' => Mage::helper('bs_ir')->__('ref_type'),
                'name'  => 'ref_type',


            ]
        );

        if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                [
                    'label' => Mage::helper('bs_ir')->__('Survey Code'),
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
                    'label' => Mage::helper('bs_ir')->__('Source'),
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
                    'label' => Mage::helper('bs_ir')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                ]
            );

            $fieldset->addField(
                'source_other',
                'text',
                [
                    'label' => Mage::helper('bs_ir')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                ]
            );
        }




        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionArray();
        $fieldset->addField(
            'dept_id',
            'select',
            [
                'label'     => Mage::helper('bs_misc')->__('Maint. Center'),
                'name'      => 'dept_id',
                'required'  => false,
                'values'    => $depts,
            ]
        );

        $locs = Mage::getResourceModel('bs_misc/location_collection');
        $locs = $locs->toOptionArray();
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

	    $customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'customer',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ir')->__('Customer'),
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
			    'label'     => Mage::helper('bs_ir')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
            ]
	    );

	    $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
	    $acRegs = $acRegs->toOptionArray();
	    array_unshift($acRegs, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'ac_reg',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ir')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
            ]
	    );

	    $fieldset->addField(
		    'ir_source',
		    'file',
		    [
			    'label' => Mage::helper('bs_ir')->__('Source'),
			    'name'  => 'ir_source',
			    //'disabled'  => $disable

            ]
	    );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_ir')->__('Report Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

	    $fieldset->addField(
		    'event_date',
		    'date',
		    [
			    'label' => Mage::helper('bs_ir')->__('Date of Event'),
			    'name'  => 'event_date',

			    'image' => $this->getSkinUrl('images/grid-cal.gif'),
			    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
	    );

	    $fieldset->addField(
		    'subject',
		    'select',
		    [
			    'label' => Mage::helper('bs_ir')->__('Ir Subject'),
			    'name'  => 'subject',
			    'values'=> Mage::getModel('bs_ir/ir_attribute_source_irsubject')->getAllOptions(false),
            ]
	    );


	    $fieldset->addField(
		    'subject_other',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Subject Other'),
			    'name'  => 'subject_other',
			    'config' => $wysiwygConfig,

            ]
	    );

	    $fieldset->addField(
		    'consequence',
		    'select',
		    [
			    'label' => Mage::helper('bs_ir')->__('Consequence'),
			    'name'  => 'consequence',
			    'values'=> Mage::getModel('bs_ir/ir_attribute_source_irconsequence')->getAllOptions(false),
            ]
	    );

	    $fieldset->addField(
		    'consequence_other',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Consequence Other'),
			    'name'  => 'consequence_other',
			    'config' => $wysiwygConfig,

            ]
	    );


	    $fieldset->addField(
		    'description',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Description'),
			    'name'  => 'description',
			    'config' => $wysiwygConfig,

            ]
	    );

        $fieldset->addField(
            'analysis',
            'textarea',
            [
                'label' => Mage::helper('bs_ir')->__('Analysis of Occurrence'),
                'name'  => 'analysis',
                'config' => $wysiwygConfig,

            ]
        );

	    $fieldset->addField(
		    'causes',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Causes of Occurrence'),
			    'name'  => 'causes',
			    'config' => $wysiwygConfig,

            ]
	    );

	    $fieldset->addField(
		    'corrective',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Corrective Actions'),
			    'name'  => 'corrective',
			    'config' => $wysiwygConfig,

            ]
	    );

	    $fieldset->addField(
		    'remark',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_ir')->__('Remark'),
			    'name'  => 'remark',
			    'config' => $wysiwygConfig,

            ]
	    );

	    $fieldset->addField(
		    'error_type',
		    'select',
		    [
			    'label' => Mage::helper('bs_ir')->__('Error Type'),
			    'name'  => 'error_type',
			    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_errortype')->getAllOptions(false),
            ]
	    );

	    $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
	    $causeGroups = $causeGroups->toOptionArray();
	    array_unshift($causeGroups, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'ncausegroup_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ir')->__('Cause Group'),
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
			    'label'     => Mage::helper('bs_ir')->__('Cause'),
			    'name'      => 'ncause_id',
			    'required'  => true,
			    'values'    => $causes,
            ]
	    );

        $bypass = Mage::getSingleton('admin/session')->isAllowed("bs_work/ir/accept");
	    if($misc->canAcceptReject($currentObj, null, [], $bypass)){//manager

		    $fieldset->addField(
			    'reject_reason',
			    'text',
			    [
				    'label' => Mage::helper('bs_ir')->__('Reject Reason'),
				    'name'  => 'reject_reason',
                ]
		    );
	    }


        $fieldset->addField(
            'repetitive',
            'select',
            [
                'label'  => Mage::helper('bs_ir')->__('Repetitive'),
                'name'   => 'repetitive',
                'values' => [
                    [
                        'value' => 1,
                        'label' => Mage::helper('bs_ir')->__('Yes'),
                    ],
                    [
                        'value' => 0,
                        'label' => Mage::helper('bs_ir')->__('No'),
                    ],
                ],

            ]
        );

        $fieldset->addField(
            'self_remark',
            'textarea',
            [
                'label' => Mage::helper('bs_ir')->__('Note'),
                'name'  => 'self_remark'

            ]
        );


        $formValues = Mage::registry('current_ir')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getIrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getIrData());
            Mage::getSingleton('adminhtml/session')->setIrData(null);
        } elseif (Mage::registry('current_ir')) {
            $formValues = array_merge($formValues, Mage::registry('current_ir')->getData());
        }
        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);

	    $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
	        ->addFieldMap('ir_subject', 'subject')
		    ->addFieldMap('ir_subject_other', 'subject_other')
		    ->addFieldMap('ir_consequence', 'consequence')
		    ->addFieldMap('ir_consequence_other', 'consequence_other')
	        ->addFieldDependence('subject_other', 'subject', ['4'])
		    ->addFieldDependence('consequence_other', 'consequence', ['6'])

	    );

        return parent::_prepareForm();
    }

	protected function _afterToHtml($html)
	{

		$id = $this->getForm()->getHtmlIdPrefix();
		$html .= "<script>
                   
                    Event.observe(document, \"dom:loaded\", function(e) {
                    		//updateSubtasks($('".$id."task_id').value);
                            //updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                            
                            
                            if($('".$id."ncausegroup_id') != undefined){ 
	                          $('".$id."ncausegroup_id').observe('change', function(){
		                          $$('.closes').each(function (el){
		                            $(el).hide();
		                          });
	                            if(checkCloseCondition()){
	                                $$('.closes').each(function (el){
			                            $(el).show();
			                          });
	                          
	                            }
	                          });
	                          
	                          Event.observe('".$id."ncausegroup_id', 'change', function(evt){
		                            updateCauses($('".$id."ncausegroup_id').value);
		                     });
                          }
                          if($('".$id."ncause_id') != undefined){ 
	                          $('".$id."ncause_id').observe('change', function(){
	                            $$('.closes').each(function (el){
		                            $(el).hide();
		                          });
	                          
	                            if(checkCloseCondition()){
	                                $$('.closes').each(function (el){
			                            $(el).show();
			                          });
	                          
	                            }
	                          });
	                          
	                          
                          }
                          if($('".$id."close_date') != undefined){ 
	                          $('".$id."close_date').observe('change', function(){
	                            $$('.closes').each(function (el){
		                            $(el).hide();
		                          });
	                          
	                            if(checkCloseCondition()){
	                                $$('.closes').each(function (el){
			                            $(el).show();
			                          });
	                          
	                            }
	                          });
	                          
	                          
                          }
                    });
                    
                    function checkCloseCondition(){
                        return ($('".$id."remark').value != '' && $('".$id."close_date').value != '');
                    
                    }
                    
                    Event.observe('".$id."task_id', 'change', function(evt){
                            updateSubtasks($('".$id."task_id').value);
                     });
                     
                     function updateCauses(group_id){
                        new Ajax.Request('".$this->getUrl('*/ncause_ncausegroup/updateCauses')."', {
                                method : 'post',
                                parameters: {
                                    'group_id'   : group_id
                                },
                                onSuccess : function(transport){
                                    try{
                                        response = eval('(' + transport.responseText + ')');
                                    } catch (e) {
                                        response = {};
                                    }
                                    if (response.causes) {

                                        if($('".$id."ncause_id') != undefined){
                                            $('".$id."ncause_id').innerHTML = response.causes;
                                        }

                                    }else {
                                        alert('Something went wrong');
                                    }

                                },
                                onFailure : function(transport) {
                                    alert('Something went wrong')
                                }
                            });
                    }

				function updateSubtasks(task_id){
                        new Ajax.Request('".$this->getUrl('*/misc_task/updateSubtasks')."', {
                                method : 'post',
                                parameters: {
                                    'task_id'   : task_id
                                },
                                onSuccess : function(transport){
                                    try{
                                        response = eval('(' + transport.responseText + ')');
                                    } catch (e) {
                                        response = {};
                                    }
                                    if (response.subtask) {

                                        if($('".$id."subtask_id') != undefined){
                                            $('".$id."subtask_id').innerHTML = response.subtask;
                                        }

                                    }else {
                                        alert('Something went wrong');
                                    }

                                },
                                onFailure : function(transport) {
                                    alert('Something went wrong')
                                }
                            });
                    }
                    
                    function updateAcreg(customer_id, ac_type){
                        new Ajax.Request('".$this->getUrl('*/acreg_acreg/updateAcreg')."', {
                                method : 'post',
                                parameters: {
                                    'customer_id'   : customer_id,
                                    'ac_type'   : ac_type
                                },
                                onSuccess : function(transport){
                                    try{
                                        response = eval('(' + transport.responseText + ')');
                                    } catch (e) {
                                        response = {};
                                    }
                                    if (response.acreg) {

                                        if($('".$id."ac_reg') != undefined){
                                            $('".$id."ac_reg').innerHTML = response.acreg;
                                        }

                                    }else {
                                        alert('Something went wrong');
                                    }

                                },
                                onFailure : function(transport) {
                                    alert('Something went wrong')
                                }
                            });
                    }
                     Event.observe('".$id."customer', 'change', function(evt){
                            updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                     });
                     
                     Event.observe('".$id."ac_type', 'change', function(evt){
                            updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                     });


                </script>";
		return parent::_afterToHtml($html);
	}
}
