<?php
chdir(getcwd());
require_once 'app/Mage.php';

umask(0);
Mage::app();

$storeId = '0';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);



$resource = Mage::getSingleton('core/resource');
$writeConnection = $resource->getConnection('core_write');
$readConnection = $resource->getConnection('core_read');
if(php_sapi_name() !== 'cli'){
    echo "Please run in command line only \n";
    return;
}

//check to prevent re-run migration

if(file_exists('app/etc/modules/BS_Surveillance.xml')){
    echo "Backing up unused Modules... \n";
    exec("mkdir -p Backup");
    exec("mkdir -p Backup/app/etc/modules");
    exec("mkdir -p Backup/app/code/local/BS");
    exec("mkdir -p Backup/app/design/adminhtml/default/default/layout");
    exec("mv app/etc/modules/*hcm.xml Backup/app/etc/modules/");
    exec("mv app/code/local/BS/*hcm Backup/app/code/local/BS/");
    exec("mv app/design/adminhtml/default/default/layout/*hcm.xml Backup/app/design/adminhtml/default/default/layout/");

//sur han
    exec("mv app/etc/modules/BS_Surveillance.xml Backup/app/etc/modules/");
    exec("mv app/etc/modules/BS_Temp.xml Backup/app/etc/modules/");
    exec("mv app/code/local/BS/Surveillance Backup/app/code/local/BS/");
    exec("mv app/code/local/BS/Temp Backup/app/code/local/BS/");
    exec("mv app/design/adminhtml/default/default/layout/bs_surveillance.xml Backup/app/design/adminhtml/default/default/layout/");


    echo "Drop unused tables... \n";
    $writeConnection->dropTable("bs_drrhcm_car");
    $writeConnection->dropTable("bs_irhcm_investigation");
    $writeConnection->dropTable("bs_ncrhcm_ncr");
    $writeConnection->dropTable("bs_otherhcm_other");
    $writeConnection->dropTable("bs_qrhcm_qrqn");
    $writeConnection->dropTable("bs_riihcm_rii");
    $writeConnection->dropTable("bs_signoffhcm_signoff");
    $writeConnection->dropTable("bs_surhcm_base");
    $writeConnection->dropTable("bs_surhcm_cimc");
    $writeConnection->dropTable("bs_surhcm_cmr");
    $writeConnection->dropTable("bs_surhcm_cofa");
    $writeConnection->dropTable("bs_surhcm_line");
    $writeConnection->dropTable("bs_surhcm_shop");
    $writeConnection->dropTable("bs_surveillance_base");
    $writeConnection->dropTable("bs_surveillance_cimc");
    $writeConnection->dropTable("bs_surveillance_cofa");
    $writeConnection->dropTable("bs_surveillance_line");
    $writeConnection->dropTable("bs_surveillance_shop");
//$writeConnection->dropTable("");
}else {
    echo "Migration is already completed... \n";
    return;
}



