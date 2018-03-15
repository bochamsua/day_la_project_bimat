<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Model_Adminhtml_Observer extends Mage_Adminhtml_Model_Observer {
	public function clearCacheConfigurationFilesAccessLevelVerification()
	{
		//Mage::app()->removeCache(Mage_Adminhtml_Block_Notification_Security::VERIFICATION_RESULT_CACHE_KEY);
		return $this;
	}
}