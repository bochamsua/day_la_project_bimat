<?php
require_once(dirname(__FILE__).'/../../public/boot.php');

class BackupGuard_BackupGuardPlatinum_Adminhtml_BackupguardplatinumController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('backupguardplatinum/backups');
        return $this;
    }

    public function backupsAction()
    {
        define('SG_PUBLIC_AJAX_URL', Mage::helper("adminhtml")->getUrl("adminhtml/backupguardplatinum/ajax"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function cloudAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function scheduleAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function settingsAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function supportAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function ajaxAction()
    {
        define('SG_CLOUD_REDIRECT_URL', Mage::helper("adminhtml")->getUrl("adminhtml/backupguardplatinum/cloud"));

        $params = $this->getRequest()->getParams();
        include(SG_PUBLIC_AJAX_PATH.$params['action'].'.php');
    }
}
