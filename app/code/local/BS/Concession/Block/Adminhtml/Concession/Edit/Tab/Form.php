<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data edit form tab
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Block_Adminhtml_Concession_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('concession_');
        $form->setFieldNameSuffix('concession');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'concession_form',
            array('legend' => Mage::helper('bs_concession')->__('Concession Data'))
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_concession/adminhtml_concession_helper_file')
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('bs_concession')->__('Concession Data Number'),
                'name'  => 'name',
	            'required'  => true

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
			    'label'     => Mage::helper('bs_concession')->__('Customer'),
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
			    'label'     => Mage::helper('bs_concession')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
		    )
	    );

	    $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
        $acRegs->setOrder('reg', 'ASC');
	    $acRegs = $acRegs->toOptionArray();
	    array_unshift($acRegs, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'ac_reg',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_concession')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );

        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_concession')->__('Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'source',
            'file',
            array(
                'label' => Mage::helper('bs_concession')->__('Source'),
                'name'  => 'source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
           )
        );

        $fieldset->addField(
            'reason',
            'select',
            array(
                'label' => Mage::helper('bs_concession')->__('Reason'),
                'name'  => 'reason',
            'required'  => true,
            'class' => 'required-entry',

            'values'=> Mage::getModel('bs_concession/concession_attribute_source_reason')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'spare_type',
            'select',
            array(
                'label' => Mage::helper('bs_concession')->__('Spare Type'),
                'name'  => 'spare_type',

            'values'=> Mage::getModel('bs_concession/concession_attribute_source_sparetype')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'spare_do',
            'date',
            array(
                'label' => Mage::helper('bs_concession')->__('Date of order'),
                'name'  => 'spare_do',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'spare_requester',
            'select',
            array(
                'label' => Mage::helper('bs_concession')->__('Requester'),
                'name'  => 'spare_requester',

            'values'=> Mage::getModel('bs_concession/concession_attribute_source_sparerequester')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'tb_type',
            'select',
            array(
                'label' => Mage::helper('bs_concession')->__('Troubleshooting Type'),
                'name'  => 'tb_type',

            'values'=> Mage::getModel('bs_concession/concession_attribute_source_tbtype')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'dt_type',
            'select',
            array(
                'label' => Mage::helper('bs_concession')->__('Downtime Type'),
                'name'  => 'dt_type',

            'values'=> Mage::getModel('bs_concession/concession_attribute_source_dttype')->getAllOptions(false),
           )
        );

        $fieldset->addField(
            'reason_source',
            'file',
            array(
                'label' => Mage::helper('bs_concession')->__('Source of reason'),
                'name'  => 'reason_source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),

           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_concession')->__('Description'),
                'name'  => 'description',

            )
        );

        $fieldset->addField(
            'cause',
            'textarea',
            array(
                'label' => Mage::helper('bs_concession')->__('Cause'),
                'name'  => 'cause',

           )
        );

        $fieldset->addField(
            'remark',
            'textarea',
            array(
                'label' => Mage::helper('bs_concession')->__('Remark'),
                'name'  => 'remark',

           )
        );



        $htmlIdPrefix = $form->getHtmlIdPrefix();
	    $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
           ->addFieldMap("{$htmlIdPrefix}reason", 'reason')
           ->addFieldMap("{$htmlIdPrefix}spare_type", 'spare_type')
           ->addFieldMap("{$htmlIdPrefix}spare_do", 'spare_do')
		    ->addFieldMap("{$htmlIdPrefix}spare_requester", 'spare_requester')
		    ->addFieldMap("{$htmlIdPrefix}tb_type", 'tb_type')
		    ->addFieldMap("{$htmlIdPrefix}dt_type", 'dt_type')
		    ->addFieldDependence('spare_type', 'reason', '1')
           ->addFieldDependence('spare_do', 'reason', '1')
		    ->addFieldDependence('spare_requester', 'reason', '1')
		    ->addFieldDependence('tb_type', 'reason', '2')
		    ->addFieldDependence('dt_type', 'reason', '3')
	    );


        $formValues = Mage::registry('current_concession')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getConcessionData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getConcessionData());
            Mage::getSingleton('adminhtml/session')->setConcessionData(null);
        } elseif (Mage::registry('current_concession')) {
            $formValues = array_merge($formValues, Mage::registry('current_concession')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }

	protected function _afterToHtml($html)
	{

		$id = $this->getForm()->getHtmlIdPrefix();
		$html .= "<script>";
		$html .= "
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
