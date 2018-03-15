<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Model_Core_Layout extends Mage_Core_Model_Layout {
	public function getOutput()
	{
		$out = '';
		if (!empty($this->_output)) {
			foreach ($this->_output as $callback) {
				$out .= $this->getBlock($callback[0])->{$callback[1]}();
			}
		}

		return $out;
	}
}