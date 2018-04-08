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
class BS_Report_Block_Adminhtml_Filter_Form extends Mage_Adminhtml_Block_Widget_Form
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
			    'year'  => $requestData['year']
            ];
	    }else { //current time
		    $formValues = [
			    'month' => Mage::getModel('core/date')->date('m', now()),
			    'year'  => Mage::getModel('core/date')->date('Y', now())
            ];
	    }

        $fieldset = $form->addFieldset('base_fieldset', ['legend'=>Mage::helper('bs_report')->__('Report for %s-%s', $formValues['month'], $formValues['year'])]);

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);


        /*$fieldset->addField('report_type', 'select', array(
                'name' => 'report_type',
                'options' => array(
                    'day'   => Mage::helper('bs_report')->__('Day'),
                    'month' => Mage::helper('bs_report')->__('Month'),
                    'year'  => Mage::helper('bs_report')->__('Year')
                ),
            'label' => Mage::helper('bs_report')->__('Period'),
            'title' => Mage::helper('bs_report')->__('Period')
        ));*/

        /*$fieldset->addField('from', 'date', array(
            'name'      => 'from',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('bs_report')->__('Date From'),
            'title'     => Mage::helper('bs_report')->__('Date From'),
        ));

        $fieldset->addField('to', 'date', array(
            'name'      => 'to',
            'format'    => $dateFormatIso,
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'label'     => Mage::helper('bs_report')->__('Date To'),
            'title'     => Mage::helper('bs_report')->__('Date To'),
        ));*/

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





	    $form->setValues($formValues);
        $form->setUseContainer(true);
        $this->setForm($form);



        return parent::_prepareForm();
    }


	public function getHeaderBar(){

        $currentUser = $this->helper('bs_misc')->getCurrentUserInfo();
		$buttons = '';
		if(Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff/reset') && $currentUser[2] == 1){//only allow QC Han Manager
			$buttons .= '<button title="Reset Report" type="button" class="scalable " onclick="filterFormReset()" style=""><span><span><span>Reset</span></span></span></button>';
		}
		$buttons .= '<button title="Refresh Report" type="button" class="scalable " onclick="filterFormRefresh()" style=""><span><span><span>Refresh</span></span></span></button>';
		$buttons .= '<button title="View Report" type="button" class="scalable " onclick="filterFormSubmit()" style=""><span><span><span>View</span></span></span></button>';
		$buttons .= '<button title="Print Report" type="button" class="scalable " onclick="filterFormPrint()" style=""><span><span><span>Print</span></span></span></button>';
		$buttons .= '<button title="Graph View" type="button" class="scalable " onclick="filterFormGraphView()" style=""><span><span><span>Graph View</span></span></span></button>';
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
				function filterFormReset() {
				    
				    if(confirm('This action will delete all data including \"Remark\",\"D2\",\"D3\". Are you sure you want to do this?')){
				        if(confirm('Just want to make sure you know what you are doing. Are you sure you want to do this, again?')){
				            var filters = $$('#filter_form input', '#filter_form select');
                            var elements = [];
                            for(var i in filters){
                                if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
                            }
                            var validator  = new Validation('filter_form');
                            if (validator.validate()) {
                                setLocation('".$this->getResetUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/');
                            }
				        }
				    }
			        
			    }
			    
			    function filterFormRefresh() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			        var validator  = new Validation('filter_form');
			        if (validator.validate()) {
			            setLocation('".$this->getFilterUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/refresh/1');
			        }
			    }
			    
			    function filterFormGraphView() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			        var validator  = new Validation('filter_form');
			        if (validator.validate()) {
			            setLocation('".$this->getFilterUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/dograph/1');
			        }
			    }
			    
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
			    
			    function updateButtonSubmit() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			
			        var inputs = $$('table tbody input.input-text');
			        var data = [];
			
			        for(var j in inputs){
			            if(inputs[j].value && inputs[j].value.length && !inputs[j].disabled) data.push(inputs[j]);
			        }
			
			        //console.log(Form.serializeElements(data));
			        new Ajax.Request('". $this->getUpdateUrl()."', {
			            method : 'post',
			            parameters: {
			                'filter'   : encode_base64(Form.serializeElements(elements)),
			                'data'   : encode_base64(Form.serializeElements(data))
			            },
			            onSuccess : function(transport){
			                try{
			                    response = eval('(' + transport.responseText + ')');
			                    setLocation('".$this->getGridUrl()."filter/'+response.filter+'/');
			                } catch (e) {
			                    response = {};
			                    alert('Something went wrong');
			                }s
			
			            },
			            onFailure : function(transport) {
			                alert('Something went wrong')
			            }
			        });
			
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
