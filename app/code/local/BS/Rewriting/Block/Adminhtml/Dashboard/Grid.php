<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Dashboard_Grid extends Mage_Adminhtml_Block_Dashboard_Grid {
	public function __construct()
	{
		parent::__construct();
		$this->setDefaultLimit(50);
	}
}