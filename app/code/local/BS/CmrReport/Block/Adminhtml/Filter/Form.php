<?php
/**
 * BS_Report extension
 *
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation admin block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_CmrReport_Block_Adminhtml_Filter_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/report');
        $form = new Varien_Data_Form(
            ['id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get']
        );
        $htmlIdPrefix = 'report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);

	    $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
	    if(count($requestData)){
		    $formValues = [
			    'month' => $requestData['month'],
			    'year'  => $requestData['year'],
                'customer'  => $requestData['customer']
            ];
	    }else { //current time
		    $formValues = [
			    'month' => Mage::getModel('core/date')->date('m', now()),
			    'year'  => Mage::getModel('core/date')->date('Y', now()),
                'customer'  => 0
            ];
	    }

	    $customer = $formValues['customer'];
	    if($customer > 0){
	        $customerModel = Mage::getSingleton('bs_acreg/customer')->load($customer);
	        $customer = $customerModel->getName();
        }else {
	        $customer = 'All';
        }

        $fieldset = $form->addFieldset('base_fieldset', ['legend'=>Mage::helper('bs_report')->__('CMR Report for %s-%s (%s)', $formValues['month'], $formValues['year'], $customer)]);

        //$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);


	    $fieldset->addField('month', 'select', [
		    'name' => 'month',
		    'options' => $this->helper('bs_report')->getMonths(),
		    'label' => Mage::helper('reports')->__('Month'),
		    'title' => Mage::helper('reports')->__('Month')
        ]);

	    $fieldset->addField('year', 'select', [
		    'name' => 'year',
		    'options' => $this->helper('bs_report')->getYears(),
		    'label' => Mage::helper('reports')->__('Year'),
		    'title' => Mage::helper('reports')->__('Year')
        ]);

        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'customer',
            'select',
            [
                'label'     => Mage::helper('bs_cmr')->__('Customer'),
                'name'      => 'customer',
                'required'  => false,
                'values'    => $customers,
            ]
        );




	    $form->setValues($formValues);
        $form->setUseContainer(true);
        $this->setForm($form);



        return parent::_prepareForm();
    }


	public function getHeaderBar(){

		$buttons = '';
		$buttons .= '<button title="View Report" type="button" class="scalable " onclick="filterFormSubmit()" style=""><span><span><span>View</span></span></span></button>';
		$buttons .= '<button title="Print Report" type="button" class="scalable " onclick="filterFormPrint()" style=""><span><span><span>Print</span></span></span></button>';
		//$buttons .= '<button title="View Report" type="button" class="scalable " onclick="filterFormView()" style=""><span><span><span>View Report</span></span></span></button>';
		return $buttons;
	}

	public function getResetUrl()
	{
		//$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/reset', ['_current' => false]);
	}



	public function getUpdateUrl()
	{
		//$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/update', ['_current' => false]);
	}

	public function getPrintUrl()
	{
		//$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/print', ['_current' => false]);
	}

	public function getFilterUrl()
	{
		//$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/report', ['_current' => false]);
	}

	public function getGridUrl(){
		return $this->getUrl('*/*/');
	}


	protected function _afterToHtml( $html ) {
		$html .= "<script>
				
			    
			    function filterFormPrint() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			        var validator  = new Validation('filter_form');
			        if (validator.validate()) {
			            setLocation('".$this->getPrintUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/');
			        }
			    }
			    
			 
			    
			    function filterFormSubmit() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			        var validator  = new Validation('filter_form');
			        if (validator.validate()) {
			            setLocation('".$this->getFilterUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/');
			        }
			    }
                    
                </script>";

		return parent::_afterToHtml($html);
	}

}
