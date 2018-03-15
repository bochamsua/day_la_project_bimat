<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_System_Config_Form_Fieldset extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {
	protected function _getHeaderHtml($element)
	{
		if ($element->getIsNested()) {
			$html = '<tr class="nested"><td colspan="4"><div class="' . $this->_getFrontendClass($element) . '">';
		} else {
			$html = '<div class="' . $this->_getFrontendClass($element) . '">';
		}

		$html .= $this->_getHeaderTitleHtml($element);

		$html .= '<input id="'.$element->getHtmlId() . '-state" name="config_state[' . $element->getId()
		         . ']" type="hidden" value="' . (int)$this->_getCollapseState($element) . '" />';
		$html .= '<fieldset class="' . $this->_getFieldsetCss($element) . '" id="' . $element->getHtmlId() . '">';
		$html .= '<legend>' . $element->getLegend() . '</legend>';

		$html .= $this->_getHeaderCommentHtml($element);

		// field label column
		$html .= '<div class="table-responsive"><table cellspacing="0" class="form-list"><colgroup class="label" /><colgroup class="value" />';
		if ($this->getRequest()->getParam('website') || $this->getRequest()->getParam('store')) {
			$html .= '<colgroup class="use-default" />';
		}
		$html .= '<colgroup class="scope-label" /><colgroup class="" /><tbody>';

		return $html;
	}

	protected function _getFooterHtml($element)
	{
		$tooltipsExist = false;
		$html = '</tbody></table></div>';
		$html .= '</fieldset>' . $this->_getExtraJs($element, $tooltipsExist);

		if ($element->getIsNested()) {
			$html .= '</div></td></tr>';
		} else {
			$html .= '</div>';
		}
		return $html;
	}
}