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
class BS_Report_Block_Adminhtml_Filter_Workdayform extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/report');
        $form = new Varien_Data_Form(
            ['id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get']
        );
        $htmlIdPrefix = 'report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldset = $form->addFieldset('base_fieldset', ['legend'=>Mage::helper('bs_report')->__('Select Year to generate work days')]);

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

	   /* $fieldset->addField('month', 'select', array(
		    'name' => 'month',
		    'options' => $this->helper('bs_report')->getMonths(),
		    'label' => Mage::helper('reports')->__('Month'),
		    'title' => Mage::helper('reports')->__('Month')
	    ));*/

	    $fieldset->addField('year', 'select', [
		    'name' => 'year',
		    'options' => $this->helper('bs_report')->getYears(),
		    'label' => Mage::helper('reports')->__('Year'),
		    'title' => Mage::helper('reports')->__('Year')
        ]);

        $form->setUseContainer(true);
        $this->setForm($form);



        return parent::_prepareForm();
    }

	public function getHeaderBar(){
		$buttons = '<button title="Refresh Report" type="button" class="scalable " onclick="filterFormSubmit()" style=""><span><span><span>Generate work days</span></span></span></button>';
		return $buttons;
	}

	public function getFilterUrl()
	{
		$this->getRequest()->setParam('filter', null);
		return $this->getUrl('*/*/generateWorkday', ['_current' => true]);
	}

	protected function _afterToHtml( $html ) {
		$html .= "<script>
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
