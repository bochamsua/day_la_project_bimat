<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance edit form tab
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Block_Adminhtml_Sur_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Sur_Block_Adminhtml_Sur_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('sur_');
        $form->setFieldNameSuffix('sur');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'sur_form',
            ['legend' => Mage::helper('bs_sur')->__('Surveillance')]
        );

        $currentSur = Mage::registry('current_sur');
        $taskId = null;
        if($currentSur->getId()){
            $taskId = $currentSur->getTaskId();
        }

        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_sur/adminhtml_sur_helper_file')
        );

        /*$fieldset->addField(
            'ref_no',
            'text',
            array(
                'label' => Mage::helper('bs_sur')->__('Reference No'),
                'name'  => 'ref_no',
            'required'  => true,
            'class' => 'required-entry',

           )
        );*/


        /*$fieldset->addField(
            'ins_id',
            'text',
            array(
                'label' => Mage::helper('bs_sur')->__('Inspector'),
                'name'  => 'ins_id',

           )
        );*/

        $fieldset->addField(
            'dept_id',
            'select',
            [
                'label'     => Mage::helper('bs_sur')->__('Maint. Center'),
                'name'      => 'dept_id',
                'required'  => false,
                'values'    => Mage::helper('bs_misc/dept')->getDepts(false, false, false),
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
                'label'     => Mage::helper('bs_sur')->__('Location'),
                'name'      => 'loc_id',
                'required'  => false,
                'values'    => $locs,
            ]
        );

        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'customer',
            'select',
            [
                'label'     => Mage::helper('bs_sur')->__('Customer'),
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
                'label'     => Mage::helper('bs_sur')->__('A/C Type'),
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
                'label'     => Mage::helper('bs_sur')->__('A/C Reg'),
                'name'      => 'ac_reg',
                'required'  => false,
                'values'    => $acRegs,
            ]
        );



        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_sur')->__('Date of Inspection'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );


        $fieldset->addField(
            'sur_source',
            'file',
            [
                'label' => Mage::helper('bs_sur')->__('Source'),
                'name'  => 'sur_source',
                'note'  => Mage::helper('bs_sur')->__('Maximum file size allowed is 10MB'),

            ]
        );

        $fieldset->addField(
            'mandatory_items',
            'text',
            [
                'label' => Mage::helper('bs_sur')->__('Mandatory Items'),
                'name'  => 'mandatory_items',

            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_sur')->__('Description (Work detail)'),
                'name'  => 'description',

            ]
        );

        $tasks = Mage::getResourceModel('bs_misc/task_collection');
       /* if($taskGroupId){
            $tasks->addFieldToFilter('taskgroup_id', $taskGroupId);
        }*/
        $tasks = $tasks->toOptionArray();
        /*if(!in_array($taskGroupId, array(4,5))){
            array_unshift($tasks, array('value'=>'0', 'label'=>'N/A'));
        }*/

        $fieldset->addField(
            'task_id',
            'select',
            [
                'label' => Mage::helper('bs_sur')->__('Survey Code'),
                'name'  => 'task_id',
                'values'=> $tasks,
                //'disabled'  => $disable
            ]
        );


        $subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
        if($taskId){
            $subtasks->addFieldToFilter('task_id', $taskId);
        }
        $subtasks = $subtasks->toOptionArrayFull();
        array_unshift($subtasks, ['value'=>'0', 'label'=>'N/A']);


        $fieldset->addField(
            'subtask_id',
            'multiselect',
            [
                'label' => Mage::helper('bs_sur')->__('Survey Sub Code'),
                'name'  => 'subtask_id',
                'values'=> $subtasks,
                //'disabled'  => $disable
            ]
        );

        /*$fieldset->addField(
            'check_type',
            'select',
            array(
                'label' => Mage::helper('bs_sur')->__('Check Type'),
                'name'  => 'check_type',
                'values'=> Mage::getModel('bs_sur/sur_attribute_source_checktype')->getAllOptions(false),
            )
        );*/

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_sur')->__('Remark (Outstanding Note)'),
                'name'  => 'remark_text',

            ]
        );

        $fieldset->addField(
            'remind_text',
            'textarea',
            [
                'label' => Mage::helper('bs_sur')->__('Remind (Fault not record into report)'),
                'name'  => 'remind_text',

            ]
        );

        $fieldset->addField(
            'region',
            'hidden',
            [
                'label' => Mage::helper('bs_sur')->__('Region'),
                'name'  => 'region',
                //'values'=> Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false),
            ]
        );

        $fieldset->addField(
            'section',
            'hidden',
            [
                'label' => Mage::helper('bs_sur')->__('Section'),
                'name'  => 'section',

            //'values'=> Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false),
            ]
        );

        $formValues = Mage::registry('current_sur')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }

        if($from = $this->getRequest()->getParam('from')){
            $sur = Mage::getModel('bs_sur/sur')->load($from);
            $oldData = $sur->getData();
            unset($oldData['entity_id']);
            unset($oldData['ref_no']);
            unset($oldData['created_at']);
            unset($oldData['updated_at']);
            $formValues = array_merge($formValues, $oldData);
        }


        $currentUser = $this->helper('bs_misc')->getCurrentUserInfo();
        $formValues = array_merge($formValues, ['region' => $currentUser[2], 'section' => $currentUser[3]]);//region - section

        if (Mage::getSingleton('adminhtml/session')->getSurData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSurData());
            Mage::getSingleton('adminhtml/session')->setSurData(null);
        } elseif (Mage::registry('current_sur')) {
            $formValues = array_merge($formValues, Mage::registry('current_sur')->getData());
        }
        $form->setValues($formValues);
        $this->setChild('form_after', $this->helper('bs_misc')->getFieldDependence($form->getFieldNameSuffix()));

        return parent::_prepareForm();
    }

    protected function _afterToHtml($html)
    {
        $currentId = 0;
        if(Mage::registry('current_sur')->getId()){
            $currentId = Mage::registry('current_sur')->getId();
        }

        $id = $this->getForm()->getHtmlIdPrefix();
        $html .= "<script>";

        if(!Mage::registry('current_sur')->getId()){
            $html .= "Event.observe(document, \"dom:loaded\", function(e) {
                           //updateTasks($('".$id."dept_id').value);
                           
                           //updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                          
                    });
                    
              
                    ";
        }

        $html .= "
                    Event.observe('".$id."customer', 'change', function(evt){
                            updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                     });
                     
                    Event.observe('".$id."ac_type', 'change', function(evt){
                            updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
                     });
                    Event.observe('".$id."task_id', 'change', function(evt){
                            updateSubtasks($('".$id."task_id').value, 'sur', ".$currentId.");
                     });
                     
                      Event.observe('".$id."dept_id', 'change', function(evt){
                            updateTasks($('".$id."dept_id').value);
                     });
                     
                     function updateTasks(dept_id){
                        new Ajax.Request('".$this->getUrl('*/misc_task/updateTasks')."', {
                                method : 'post',
                                parameters: {
                                    'dept_id'   : dept_id
                                },
                                onSuccess : function(transport){
                                    try{
                                        response = eval('(' + transport.responseText + ')');
                                    } catch (e) {
                                        response = {};
                                    }
                                    if (response.task) {

                                        if($('".$id."task_id') != undefined){
                                            $('".$id."task_id').innerHTML = response.task;
                                            updateSubtasks($('".$id."task_id').value, 'sur', ".$currentId.");
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
                    
                     function updateSubtasks(task_id, ref_type, ref_id){
                        new Ajax.Request('".$this->getUrl('*/misc_task/updateSubtasks')."', {
                                method : 'post',
                                parameters: {
                                    'task_id'   : task_id,
                                    'ref_type' : ref_type,
                                    'ref_id' : ref_id,
                                    'full': 1
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
                     
                </script>";
        return parent::_afterToHtml($html);
    }
}
