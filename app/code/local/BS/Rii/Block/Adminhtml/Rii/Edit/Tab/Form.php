<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off edit form tab
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Block_Adminhtml_Rii_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Rii_Block_Adminhtml_Rii_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('rii_');
        $form->setFieldNameSuffix('rii');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'rii_form',
            array('legend' => Mage::helper('bs_rii')->__('RII Sign-off'))
        );

        $tasks = Mage::getResourceModel('bs_misc/task_collection')->addFieldToFilter('taskgroup_id', 6);
        $tasks = $tasks->toOptionArray();
        $taskcode = $fieldset->addField(
            'task_id',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('Task Code'),
                'name'      => 'task_id',
                'required'  => false,
                'values'    => $tasks,
                //'after_element_html' => $html
            )
        );



        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionArray();
        $fieldset->addField(
            'dept_id',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('Maint. Center'),
                'name'      => 'dept_id',
                'required'  => false,
                'values'    => $depts,
            )
        );

        $locs = Mage::getResourceModel('bs_misc/location_collection');
        $locs = $locs->toOptionArray();
		array_unshift($locs, ['value' => 0, 'label' => 'N/A']);
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

	    $customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'customer',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_rii')->__('Customer'),
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
			    'label'     => Mage::helper('bs_rii')->__('A/C Type'),
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
			    'label'     => Mage::helper('bs_rii')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );



        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_rii')->__('Date of Inspection'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'wp',
            'text',
            array(
                'label' => Mage::helper('bs_rii')->__('Workpack'),
                'name'  => 'wp',

           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_rii')->__('Description'),
                'name'  => 'description',
                'config' => $wysiwygConfig,

           )
        );




        $formValues = Mage::registry('current_rii')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getRiiData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getRiiData());
            Mage::getSingleton('adminhtml/session')->setRiiData(null);
        } elseif (Mage::registry('current_rii')) {
            $formValues = array_merge($formValues, Mage::registry('current_rii')->getData());
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
