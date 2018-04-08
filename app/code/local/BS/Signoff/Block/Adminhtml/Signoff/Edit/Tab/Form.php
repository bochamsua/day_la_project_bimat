<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off edit form tab
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Block_Adminhtml_Signoff_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('signoff_');
        $form->setFieldNameSuffix('signoff');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'signoff_form',
            ['legend' => Mage::helper('bs_signoff')->__('AC Sign-off')]
        );


        $tasks = Mage::getResourceModel('bs_misc/task_collection')->addFieldToFilter('taskgroup_id', 7);
        $tasks = $tasks->toOptionArray();
        $taskcode = $fieldset->addField(
            'task_id',
            'select',
            [
                'label'     => Mage::helper('bs_misc')->__('Task Code'),
                'name'      => 'task_id',
                'required'  => false,
                'values'    => $tasks,
                //'after_element_html' => $html
            ]
        );

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
			    'label'     => Mage::helper('bs_signoff')->__('Customer'),
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
			    'label'     => Mage::helper('bs_signoff')->__('A/C Type'),
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
			    'label'     => Mage::helper('bs_signoff')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
            ]
	    );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_signoff')->__('Date of Inspection'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'wp',
            'text',
            [
                'label' => Mage::helper('bs_signoff')->__('Workpack'),
                'name'  => 'wp',

            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_signoff')->__('Description'),
                'name'  => 'description',
                'config' => $wysiwygConfig,

            ]
        );



        $formValues = Mage::registry('current_signoff')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getSignoffData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSignoffData());
            Mage::getSingleton('adminhtml/session')->setSignoffData(null);
        } elseif (Mage::registry('current_signoff')) {
            $formValues = array_merge($formValues, Mage::registry('current_signoff')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }

	protected function _afterToHtml($html)
	{

		$id = $this->getForm()->getHtmlIdPrefix();
		$html .= "<script>
                   
                    Event.observe(document, \"dom:loaded\", function(e) {
                            //updateAcreg($('".$id."customer').value, $('".$id."ac_type').value);
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
