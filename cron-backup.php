<?php
chdir(dirname(__FILE__));
require_once 'app/Mage.php';

umask(0);
Mage::app();

$storeId = '0';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

//update overdue
Mage::getModel('backupguardplatinum/cron')->run();















