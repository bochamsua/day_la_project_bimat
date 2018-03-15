<?php

/**
 * BS_Wysiwyg extension
 *
 * @category       BS
 * @package        BS_Wysiwyg
 * @copyright      Copyright (c) 2017
 */

class BS_Wysiwyg_Model_Observer
{
    public function addJs(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block && $block instanceof Mage_Adminhtml_Block_Page_Head) {

        	if(Mage::getModel('cms/wysiwyg_config')->isEnabled()){

		        $transport = $observer->getEvent()->getTransport();
		        $transportHtml = $transport->getHtml();
		        $transportHtml .= $block->getLayout()->createBlock('core/template')->setTemplate('bs_wysiwyg/js.phtml')->toHtml();
		        $transport->setHtml($transportHtml);
	        }

        }
    }


}