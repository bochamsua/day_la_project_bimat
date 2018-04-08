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
            ['legend' => Mage::helper('bs_drr')->__('Drr')]
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
                'disabled'  => $disable

           )
        );*/

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_drr')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_drr')->__('Report Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
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
			    'label'     => Mage::helper('bs_drr')->__('Customer'),
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
			    'label'     => Mage::helper('bs_drr')->__('A/C Type'),
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
			    'label'     => Mage::helper('bs_drr')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
            ]
	    );

	    $fieldset->addField(
		    'flight_no',
		    'text',
		    [
			    'label' => Mage::helper('bs_drr')->__('Flight No'),
			    'name'  => 'flight_no',
			    'disabled'  => $disable

            ]
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
            [
                'label' => Mage::helper('bs_drr')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable,
	            'config'    => $wysiwygConfig

            ]
        );

        $fieldset->addField(
            'due_date',
            'date',
            [
                'label' => Mage::helper('bs_drr')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
            ]
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
	    if($currentObj->getDrrStatus() == 1 && !$misc->isAdmin($currentObj)){//closed, disable but still allow admin edit
		    $disableProof = true;
	    }

	    $fieldset->addField(
		    'remark',
		    'file',
		    [
			    'label' => Mage::helper('bs_drr')->__('Proof of Close'),
			    'name'  => 'remark',
			    'disabled'  => $disableProof

            ]
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
            [
                'label' => Mage::helper('bs_drr')->__('Close Date'),
                'name'  => 'close_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
            ]
        );




	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'drr_status',
			    'select',
			    [
				    'label' => Mage::helper('bs_drr')->__('Status'),
				    'name'  => 'drr_status',

				    'values'=> Mage::getModel('bs_drr/drr_attribute_source_drrstatus')->getAllOptions(false),
                ]
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
            [
                'label' => Mage::helper('bs_drr')->__('Note'),
                'name'  => 'self_remark'

            ]
        );





        $formValues = Mage::registry('current_drr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getDrrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getDrrData());
            Mage::getSingleton('adminhtml/session')->setDrrData(null);
        } elseif (Mage::registry('current_drr')) {
            $formValues = array_merge($formValues, Mage::registry('current_drr')->getData());
        }
        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);
        return parent::_prepareForm();
    }

    protected function _afterToHtml($html)
    {

	    $id = $this->getForm()->getHtmlIdPrefix();
        $html .= "<script>
                   
                    Event.observe(document, \"dom:loaded\", function(e) {
                    	//updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                    
                          $$('.closes').each(function (el){
                            $(el).hide();
                          });
                          
                          $('".$id."remark').observe('change', function(){
	                          $$('.closes').each(function (el){
	                            $(el).hide();
	                          });
                          
                            if(checkCloseCondition()){
                                $$('.closes').each(function (el){
		                            $(el).show();
		                          });
                          
                            }
                          });
                          
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
                    
                    function checkCloseCondition(){
                        return ($('".$id."remark').value != '' && $('".$id."close_date').value != '');
                    
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

					Event.observe('".$id."task_id', 'change', function(evt){
                            updateSubtasks($('".$id."task_id').value);
                     });

                </script>";
        return parent::_afterToHtml($html);
    }
}
