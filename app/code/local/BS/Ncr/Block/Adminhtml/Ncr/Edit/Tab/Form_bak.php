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
            array('legend' => Mage::helper('bs_ncr')->__('NCR'))
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
            array(
                'label' => Mage::helper('bs_ncr')->__('ref_id'),
                'name'  => 'ref_id',


            )
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            array(
                'label' => Mage::helper('bs_ncr')->__('ref_type'),
                'name'  => 'ref_type',


            )
        );


	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_ncr')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
		    )
	    );


        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_ncr/adminhtml_ncr_helper_file')
        );



        $disable = false;
        if($misc->isManager($currentObj) && $currentObj->getId()){
            $disable = true;
        }

        if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                array(
                    'label' => Mage::helper('bs_ncr')->__('Ncrvey Code'),
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
                    'label' => Mage::helper('bs_ncr')->__('Source'),
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
                    'label' => Mage::helper('bs_ncr')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                )
            );

            $fieldset->addField(
                'source_other',
                'text',
                array(
                    'label' => Mage::helper('bs_ncr')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                )
            );
        }



	    $fieldset->addField(
		    'repetitive',
		    'select',
		    array(
			    'label'  => Mage::helper('bs_ncr')->__('Repetitive'),
			    'name'   => 'repetitive',
			    'values' => array(
				    array(
					    'value' => 1,
					    'label' => Mage::helper('bs_ncr')->__('Yes'),
				    ),
				    array(
					    'value' => 0,
					    'label' => Mage::helper('bs_ncr')->__('No'),
				    ),
			    ),
			    'disabled'  => $disable
		    )
	    );

        $fieldset->addField(
            'ncr_source',
            'file',
            array(
                'label' => Mage::helper('bs_ncr')->__('Source'),
                'name'  => 'ncr_source',
                'disabled'  => $disable

           )
        );


	    $fieldset->addField(
		    'report_date',
		    'date',
		    array(
			    'label' => Mage::helper('bs_ncr')->__('Report Date'),
			    'name'  => 'report_date',
			    'image' => $this->getSkinUrl('images/grid-cal.gif'),
			    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),


		    )
	    );


        $fieldset->addField(
            'ref_doc',
            'text',
            array(
                'label' => Mage::helper('bs_ncr')->__('REF Doc'),
                'name'  => 'ref_doc',
                'disabled'  => $disable


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

	    $locs = Mage::getResourceModel('bs_misc/location_collection');
	    $locs = $locs->toOptionArray();
		array_unshift($locs, ['value' => 0, 'label' => 'N/A']);
	    array_unshift($locs, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'loc_id',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_misc')->__('Location'),
			    'name'      => 'loc_id',
			    'required'  => false,
			    'values'    => $locs,
		    )
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
            array(
                'label' => Mage::helper('bs_ncr')->__('Type'),
                'name'  => 'ncr_type',

            'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_ncrtype')->getAllOptions(false),
                'disabled'  => $disable
           )
        );

	    $fieldset->addField(
		    'error_type',
		    'select',
		    array(
			    'label' => Mage::helper('bs_ncr')->__('Error Type'),
			    'name'  => 'error_type',

			    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_errortype')->getAllOptions(false),
			    'disabled'  => $disable
		    )
	    );

        $fieldset->addField(
            'point',
            'text',
            array(
                'label' => Mage::helper('bs_ncr')->__('Point'),
                'name'  => 'point',
                'disabled'  => $disable


            )
        );


        $fieldset->addField(
		    'short_desc',
		    'text',
		    array(
			    'label' => Mage::helper('bs_ncr')->__('Short Description'),
			    'name'  => 'short_desc',
			    'disabled'  => $disable,
			    'maxlength' => 75


		    )
	    );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_ncr')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable,


            )
        );

        $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_ncr')->__('Due Date'),
                'name'  => 'due_date',
                'readonly'  => true,
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
           )
        );



	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'ncr_status',
			    'select',
			    array(
				    'label' => Mage::helper('bs_ncr')->__('Status'),
				    'name'  => 'ncr_status',

				    'values'=> Mage::getModel('bs_ncr/ncr_attribute_source_ncrstatus')->getAllOptions(false),
			    )
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


        if(in_array($currentObj->getNcrStatus(), array(2,3,4,5,6))){// && $currentObj->getAccept() == 1
	        $disableProof = false;
	        if($currentObj->getNcrStatus() == 3 && !$misc->isAdmin($currentObj)){//closed, disable but still allow admin edit
		        $disableProof = true;
	        }
            $fieldset->addField(
                'remark',
                'file',
                array(
                    'label' => Mage::helper('bs_ncr')->__('Proof of Close'),
                    'name'  => 'remark',
                    'disabled'  => $disableProof

                )
            );

	        $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
	        $causeGroups = $causeGroups->toOptionArray();
	        array_unshift($causeGroups, array('value' => 0, 'label' => 'N/A'));
	        $fieldset->addField(
		        'ncausegroup_id',
		        'select',
		        array(
			        'label'     => Mage::helper('bs_ncr')->__('Cause Group'),
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
			        'label'     => Mage::helper('bs_ncr')->__('Cause'),
			        'name'      => 'ncause_id',
			        'required'  => true,
			        'values'    => $causes,
		        )
	        );
        }

	    $fieldset->addField(
		    'remark_text',
		    'textarea',
		    array(
			    'label' => Mage::helper('bs_ncr')->__('Remark'),
			    'name'  => 'remark_text',
			    'disabled'  => $disable,
			    'config' => $wysiwygConfig,

		    )
	    );




        $fieldset->addField(
            'close_date',
            'date',
            array(
                'label' => Mage::helper('bs_ncr')->__('Close Date'),
                'name'  => 'close_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
           )
        );


        $bypass = Mage::getSingleton('admin/session')->isAllowed("bs_work/ncr/accept");
        if($misc->canAcceptReject($currentObj, null, [], $bypass)){//manager

            $fieldset->addField(
                'reject_reason',
                'text',
                array(
                    'label' => Mage::helper('bs_ncr')->__('Reject Reason'),
                    'name'  => 'reject_reason',
                )
            );
        }
        $fieldset->addField(
            'self_remark',
            'textarea',
            array(
                'label' => Mage::helper('bs_ncr')->__('Note'),
                'name'  => 'self_remark'

            )
        );


        $formValues = Mage::registry('current_ncr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getNcrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNcrData());
            Mage::getSingleton('adminhtml/session')->setNcrData(null);
        } elseif (Mage::registry('current_ncr')) {
            $formValues = array_merge($formValues, Mage::registry('current_ncr')->getData());
        }

        $formValues = array_merge($formValues, array(
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ));

        $form->setValues($formValues);

        $idPrefix = $form->getHtmlIdPrefix();
	    /*$this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
	                                       ->addFieldMap($idPrefix.'short_desc', 'short_desc')
	                                       ->addFieldMap($idPrefix.'description', 'description')
	                                       ->addFieldDependence('description', 'short_desc', array('isnull' => false))

	    );*/

        return parent::_prepareForm();
    }

    protected function _afterToHtml($html)
    {

        $id = $this->getForm()->getHtmlIdPrefix();
	    $html .= "<script>";

	    if(!Mage::registry('current_ncr')->getId()){
	    	$html .= "Event.observe(document, \"dom:loaded\", function(e) {
                           updateDueDate();
                           updateSubtasks($('".$id."task_id').value);
                           updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                           
                           if($('".$id."short_desc').value == ''){
                              $('".$id."description').up('tr').hide(); 
                           }
                           
                           $('".$id."short_desc').observe('change', function(){
                                $('".$id."description').up('tr').show(); 
                           });
                    });
                    
                 
                    ";
	    }


        $html .= "
                    
                    
                    
                    Event.observe(document, \"dom:loaded\", function(e) {
                          $$('.closes').each(function (el){
                            $(el).hide();
                          });
                          
                          if($('".$id."remark') != undefined){
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
                          }
                          
                          
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
                        return ($('".$id."remark').value != '' && $('".$id."ncausegroup_id').value != 0 && $('".$id."ncause_id') != 0 && $('".$id."close_date').value != '');
                    
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
                    
                    function updateDueDate(){
                        var type_id = $('".$id."ncr_type').value;
                        var report_date = $('".$id."report_date').value;
                        
                        if(type_id != '' && report_date != ''){
                            var dateArray = report_date.split('/');
                            var addDay = 0;
                            switch(type_id){
                                case '1':
                                    addDay = 3;
                                    break;
                                case '2':
                                    addDay = 10;
                                    break;
                               
                                default:
                                    break;
                                    
                            }
                            //console.log(dateArray);
                            var result = new Date(dateArray[2], dateArray[1]-1, dateArray[0]);
                            result.setDate(result.getDate() + addDay);
                            
                            var dayday = result.getDate();
                            if(dayday < 10) {
                                dayday = '0' + dayday;
                            }
                            var month = result.getMonth() * 1 + 1;
                            if(month < 10) {
                                month = '0' + month;
                            }
                            
                            var duedate = dayday + '/' + month + '/' + result.getFullYear();
                                                        
                            if($('".$id."due_date') != undefined){
                                $('".$id."due_date').value = duedate;
                            }
                        }
                        
                    
                        
                    }
                     Event.observe('".$id."task_id', 'change', function(evt){
                            updateSubtasks($('".$id."task_id').value);
                     });
                     
                     
                     
                     //update due date according to type
                     Event.observe('".$id."ncr_type', 'change', function(evt){
                        updateDueDate();
                     });
                     Event.observe('".$id."report_date', 'change', function(evt){
                        updateDueDate();
                     });
                     
                     

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
