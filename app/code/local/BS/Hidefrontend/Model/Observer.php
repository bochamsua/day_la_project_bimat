<?php
/**
 * BS_Hidefrontend extension
 * 
 * @category       BS
 * @package        BS_Hidefrontend
 * @copyright      Copyright (c) 2016
 */
/**
 * Hiddd model
 *
 * @category    BS
 * @package     BS_Hidefrontend
 * @author Bui Phong
 */
class BS_Hidefrontend_Model_Observer
{
    public function hideFrontend()
    {
        Mage::app()->getResponse()->setRedirect(Mage::getUrl('adminhtml'))->sendResponse();
        exit();
    }
}
