<?php

class BS_Report_Block_Adminhtml_Widget_Form_Renderer_Fieldset extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset {

	public function getElement(){
		$element = $this->_element;
		$type = $element->getForm()->getParent()->getType();
		//$buttons = $element->getContainer()->getParent()->getParentBlock()->getButtonsHtml();
		$allowedTypes = array(
			'bs_report/adminhtml_filter_form',

		);
		if($type == 'bs_report/adminhtml_filter_form'){
			$element->setHeaderBar($this->getEffHeaderBar());
		}elseif($type == 'bs_report/adminhtml_filter_workdayform'){
			$element->setHeaderBar($this->getWdaysHeaderBar());
		}

		return $element;
	}

	public function getEffHeaderBar(){

		$buttons = '';
		if(Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff/reset')){
			$buttons .= '<button title="Reset Report" type="button" class="scalable " onclick="filterFormReset()" style=""><span><span><span>Reset Report</span></span></span></button>';
		}
		$buttons .= '<button title="Refresh Report" type="button" class="scalable " onclick="filterFormSubmit()" style=""><span><span><span>View Report</span></span></span></button>';
		$buttons .= '<button title="Print Report" type="button" class="scalable " onclick="filterFormPrint()" style=""><span><span><span>Print Report</span></span></span></button>';
		//$buttons .= '<button title="Graph View" type="button" class="scalable " onclick="filterFormGraphView()" style=""><span><span><span>Graph View</span></span></span></button>';
		//$buttons .= '<button title="View Report" type="button" class="scalable " onclick="filterFormView()" style=""><span><span><span>View Report</span></span></span></button>';
		return $buttons;
	}

	public function getWdaysHeaderBar(){
		$buttons = '<button title="Refresh Report" type="button" class="scalable " onclick="filterFormSubmit()" style=""><span><span><span>Generate work days</span></span></span></button>';
		return $buttons;
	}
}