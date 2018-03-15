<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu {
	public function getMenuLevel($menu, $level = 0)
	{
		$html = '<ul ' . (!$level ? 'id="nav"' : '') . '>' . PHP_EOL;
		foreach ($menu as $item) {
			$html .= '<li ' . (!empty($item['children']) ? 'onmouseover="Element.addClassName(this,\'over\')" '
			                                               . 'onmouseout="Element.removeClassName(this,\'over\')"' : '') . ' class="'
			         . (!$level && !empty($item['active']) ? ' active' : '') . ' '
			         . (!empty($item['children']) ? ' parent' : '')
			         . (!empty($level) && !empty($item['last']) ? ' last' : '')
			         . ' level'. $level .' '.strtolower($item['label']).'"> <a href="' . $item['url'] . '" '
			         . (!empty($item['title']) ? 'title="' . $item['title'] . '"' : '') . ' '
			         . (!empty($item['click']) ? 'onclick="' . $item['click'] . '"' : '') . ' class="'
			         . ($level === 0 && !empty($item['active']) ? 'active' : '') . '"><span>'
			         . $this->escapeHtml($item['label']) . '</span></a>' . PHP_EOL;

			if (!empty($item['children'])) {
				$html .= $this->getMenuLevel($item['children'], $level + 1);
			}
			$html .= '</li>' . PHP_EOL;
		}
		$html .= '</ul>' . PHP_EOL;

		return $html;
	}
}