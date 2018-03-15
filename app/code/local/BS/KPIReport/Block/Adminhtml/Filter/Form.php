<?php
/**
 * BS_Report extension
 *
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Efficiency admin block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Filter_Form extends Mage_Adminhtml_Block_Widget_Form
{


    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/report');
        $form = new Varien_Data_Form(
            array('id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get')
        );
        $htmlIdPrefix = 'report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);

	    $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
	    if(count($requestData)){
		    $formValues = array(
			    'from_month' => $requestData['from_month'],
			    'from_year'  => $requestData['from_year'],
                'to_month' => $requestData['to_month'],
                'to_year'  => $requestData['to_year']
		    );
	    }else { //current time
		    $formValues = array(
			    'from_month' => Mage::getModel('core/date')->date('m', now()),
			    'from_year'  => Mage::getModel('core/date')->date('Y', now()),
                'to_month' => Mage::getModel('core/date')->date('m', now()),
                'to_year'  => Mage::getModel('core/date')->date('Y', now()),
		    );
	    }

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('bs_report')->__('&nbsp;', $formValues['month'], $formValues['year'])));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts->addFieldToFilter('entity_id', ['in' => [1,2,3,4,6,10,15]]);
	    $depts = $depts->toOptionArray();


        $indexes = $this->helper('bs_kpireport')->getIndexes();

        $indexOptionArray = array();
	    foreach ( $indexes as $key => $label ) {
            $indexOptionArray[] = array(
				'value' => $key,
				'label' => $label
			);
	    }


	    $fieldset->addField('report_type', 'select', array(
		    'name'      => 'report_type',
		    'label'     => Mage::helper('adminhtml')->__('Report Type'),
		    'options'   => array(
			    '1' => Mage::helper('adminhtml')->__('Individual Department Report'),
			    '2' => Mage::helper('adminhtml')->__('Multiple Deparments Report'),
		    ),
	    ), '');

	    /*$fieldset->addField('graph_type', 'select', array(
		    'name'      => 'graph_type',
		    'label'     => Mage::helper('adminhtml')->__('Graph Type'),
		    'options'   => array(
			    '1' => Mage::helper('adminhtml')->__('Separated Graphs'),
			    '2' => Mage::helper('adminhtml')->__('Merged Graph'),
		    ),
	    ), '');*/

        $fieldset->addField('index_single', 'select', array(
            'name'      => 'index_single',
            'label'     => Mage::helper('adminhtml')->__('Index'),
            'values'   => $indexOptionArray,
            //'note'      => Mage::helper('adminhtml')->__('Select report kind'),
        ),'');

        $fieldset->addField('index_multiple', 'multiselect', array(
            'name'      => 'index_multiple',
            'label'     => Mage::helper('adminhtml')->__('Index'),
            'values'   => $indexOptionArray,
            //'note'      => Mage::helper('adminhtml')->__('Select report kind'),
        ),'');

	    $fieldset->addField('dept_single', 'select', array(
		    'name'      => 'dept_single',
		    'label'     => Mage::helper('adminhtml')->__('Department'),
		    'values'    => $depts,
		    'display'   => 'none'
	    ));

	    $fieldset->addField('dept_multiple', 'multiselect', array(
		    'name'      => 'dept_multiple',
		    'label'     => Mage::helper('adminhtml')->__('Departments'),
		    'values'    => $depts,
		    'display'   => 'none'
	    ));




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

	    $fieldset->addField('from_month', 'select', array(
		    'name' => 'from_month',
		    'options' => $this->helper('bs_report')->getMonths(),
		    'label' => Mage::helper('reports')->__('From month'),
		    'class' => 'f-left'
	    ));

	    $fieldset->addField('from_year', 'select', array(
		    'name' => 'from_year',
		    'options' => $this->helper('bs_report')->getYears(),
		    'label' => Mage::helper('reports')->__('From year'),
		    'class' => 'f-left'
	    ));

	    $fieldset->addField('to_month', 'select', array(
		    'name' => 'to_month',
		    'options' => $this->helper('bs_report')->getMonths(),
		    'label' => Mage::helper('reports')->__('To month'),
	    ));

	    $fieldset->addField('to_year', 'select', array(
		    'name' => 'to_year',
		    'options' => $this->helper('bs_report')->getYears(),
		    'label' => Mage::helper('reports')->__('To year'),
	    ));


	    // define field dependencies
	    $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap("{$htmlIdPrefix}report_type", 'report_type')
            ->addFieldMap("{$htmlIdPrefix}index_single", 'index_single')
            ->addFieldMap("{$htmlIdPrefix}index_multiple", 'index_multiple')
            ->addFieldMap("{$htmlIdPrefix}dept_single", 'dept_single')
            ->addFieldMap("{$htmlIdPrefix}dept_multiple", 'dept_multiple')
            ->addFieldDependence('dept_single', 'report_type', '1')
            ->addFieldDependence('dept_multiple', 'report_type', '2')
            ->addFieldDependence('index_single', 'report_type', '2')
            ->addFieldDependence('index_multiple', 'report_type', '1')
	    );



	    $form->setValues($formValues);
        $form->setUseContainer(true);
        $this->setForm($form);



        return parent::_prepareForm();
    }

	public function getFilterUrl()
	{
		//$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/report', array('_current' => false));
	}

    public function getUpdateUrl()
    {
        //$this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/update', array('_current' => false));
    }

	public function getHeaderBar(){

		$buttons = '';
		if(Mage::getSingleton('admin/session')->isAllowed('bs_report/kpireport/update')){
			$buttons .= '<button title="Update Data" type="button" class="scalable " onclick="updateReportData()" style=""><span><span><span>Update Report Data</span></span></span></button>';
		}
		$buttons .= '<button title="Refresh Report" type="button" class="scalable " onclick="viewKPIReport()" style=""><span><span><span>View Report</span></span></span></button>';
		//$buttons .= '<button title="Print Report" type="button" class="scalable " onclick="filterFormPrint()" style=""><span><span><span>Print Report</span></span></span></button>';
		//$buttons .= '<button title="Graph View" type="button" class="scalable " onclick="filterFormGraphView()" style=""><span><span><span>Graph View</span></span></span></button>';
		//$buttons .= '<button title="View Report" type="button" class="scalable " onclick="filterFormView()" style=""><span><span><span>View Report</span></span></span></button>';
		return $buttons;
	}

	protected function _afterToHtml( $html ) {
		$html .= "<script>
			    function viewKPIReport() {
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
			    
			    function updateReportData() {
			        var filters = $$('#filter_form input', '#filter_form select');
			        var elements = [];
			        for(var i in filters){
			            if(filters[i].value && filters[i].value.length && !filters[i].disabled) elements.push(filters[i]);
			        }
			        var validator  = new Validation('filter_form');
			        if (validator.validate()) {
			            setLocation('".$this->getUpdateUrl()."filter/'+encode_base64(Form.serializeElements(elements))+'/');
			        }
			    }
			    
			    Event.observe(document, \"dom:loaded\", function(e) {
                          $('filter_form').select('.entry-edit-head').each(function(el){
				            if ($(el).select('.bs-toggle').length == 0){
				                $(el).insert({bottom:'<div class=\"collapseable\"><a href=\"#\" class=\"left bs-toggle open\"></a></div>'});
				                Event.observe($(el).select('a.bs-toggle')[0], 'click', function(e){
				                    $(this).up(1).next().toggle();
				                    $(this).toggleClassName('open');
				                    $(this).toggleClassName('closed');
				                    if($(this).hasClassName('open')){
				                        $(this).update('Hide Filter Parameters');
				                    }else {
				                        $(this).update('Show Filter Parameters');
				                    }
				                    Event.stop(e);
				                    return false;
				                });
				                //close by default
				                $(el).select('a.bs-toggle')[0].click();
				                
				            }
				        }); 
                    });
                    
			    
                    
                </script>";

		return parent::_afterToHtml($html);
	}


}
