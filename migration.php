<?php
chdir(getcwd());
//require_once 'simple_html_dom.php';
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



if(!isset($argv[1])){
    echo "======Auto mode====== \n";
    doMigration();
}else {
    try {
        //Rename tables
        if($argv[1] == 'rename'){
            if(isset($argv[2]) && isset($argv[3])){
                $old = $argv[2];
                $new = $argv[3];
                $res = $writeConnection->renameTable($old, $new);
                if($res){
                    echo "Done {$old} -> {$new} \n";
                }
            }else {
                echo "Missing arguments \n";
            }

        }

        if($argv[1] == 'changeurl'){
            if(isset($argv[2])){
                $url = $argv[2];
                $sql = "UPDATE core_config_data SET `value` = '{$url}' WHERE `path` = 'web/unsecure/base_url'; UPDATE core_config_data SET `value` = '{$url}' WHERE `path` = 'web/secure/base_url'";
                $res = $writeConnection->query($sql);
                if($res){
                    echo "Done \n";
                }
            }else {
                echo "Missing arguments \n";
            }

        }


    }catch (Exception $e){
        echo $e->getMessage()."\n";
    }
}


function doMigration(){
    try {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_read');

        //check to prevent re-run migration
        if($readConnection->isTableExists('bs_drr_drr')){
            echo "Migration is already completed... \n";
            return;
        }else {
            $url = 'http://qcvaeco.local/';
            if(!strpos($_SERVER['PWD'], "qcvaeco")){//qcvaeco is local folder
                if(strpos($_SERVER['PWD'], "staging")){
                    $url = 'http://staging.vaeco.space/';
                }else {
                    $url = 'http://qc.vaeco.space/';
                }

            }

            echo "Disabling cache... \n";
            disableCache();

            echo "Disabling Observation... \n";
            if(file_exists('app/etc/modules/BS_Observation.xml')){
                exec("mv app/etc/modules/BS_Observation.xml app/etc/modules/BS_Observation.xml.bak");
            }

            echo "Renaming tables... \n";
            //rename tables
            $tables = [
                'bs_investigation_investigation' => 'bs_ir_ir',
                'bs_car_car' => 'bs_drr_drr',
                'bs_surveillance_cmr' => 'bs_cmr_cmr',
                'bs_qrqn_qrqn' => 'bs_qr_qr'
            ];
            renameTable($writeConnection, $tables);

            echo "Updating core_resource table... \n";

            $writeConnection->update('core_resource', ['code' => 'bs_drr_setup', 'version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_car_setup'");
            $writeConnection->update('core_resource', ['code' => 'bs_ir_setup', 'version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_investigation_setup'");
            $writeConnection->update('core_resource', ['code' => 'bs_ncr_setup', 'version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_ncr_setup'");
            $writeConnection->update('core_resource', ['code' => 'bs_qr_setup', 'version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_qrqn_setup'");
            $writeConnection->update('core_resource', ['version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_rii_setup'");
            $writeConnection->update('core_resource', ['version' => '1.0.1', 'data_version' => '1.0.1'], "`code` = 'bs_concession_setup'");
            $writeConnection->insert('core_resource', ['code' => 'bs_cmr_setup', 'version' => '1.0.0', 'data_version' => '1.0.0']);



            echo "Updating URL... \n";
            $writeConnection->update('core_config_data', ['value' => $url], "`path` = 'web/unsecure/base_url'");
            $writeConnection->update('core_config_data', ['value' => $url], "`path` = 'web/secure/base_url'");
            //$sql = "UPDATE core_config_data SET `value` = '{$url}' WHERE `path` = 'web/unsecure/base_url'; UPDATE core_config_data SET `value` = '{$url}' WHERE `path` = 'web/secure/base_url'";
            //$res = $writeConnection->query($sql);

            //NOW ACCESS THE PAGE TO MAKE SURE THAT ALL MODULES ARE UPDATED

            echo "Renaming media folders... \n";
            if(file_exists('media/inv')){
                exec("mv media/inv media/ir");
            }
            if(file_exists('media/car')){
                exec("mv media/car media/drr");
            }
            if(file_exists('media/qrqn')){
                exec("mv media/qrqn media/qr");
            }




            echo "Clearing cache/sessions... \n";
            exec("rm -rf var/cache var/session");

            echo "Refreshing the page {$url} to update modules... \n";
            $content = refreshPage($url);

            echo "Wait 30 seconds to make sure the page is fully loaded... \n";
            sleep(30);


            /**
             * 3 - manager
             * 7 - Inspector
             * 16 - admin
             * 87 - viewer
             * 142 - Vice Manager
             * 221 - HCM Manager
             * 317 - HCM Admin
             * 318 - HCM Vice Manager
             * 319 - HCM Inspector
             */
            echo "Updating users roles/region/section... \n";

            $writeConnection->update('admin_user', ['region' => '1', 'section' => '1']);
            $writeConnection->update('admin_user', ['region' => '2'], "user_id IN (SELECT user_id FROM admin_role WHERE role_type = 'U' AND parent_id IN(221,317,318,319))");

            $writeConnection->update('admin_role', ['parent_id' => '3'], "parent_id = 221");
            $writeConnection->update('admin_role', ['parent_id' => '7'], "parent_id = 319");
            $writeConnection->update('admin_role', ['parent_id' => '16'], "parent_id = 317");
            $writeConnection->update('admin_role', ['parent_id' => '142'], "parent_id = 318");

            //now change and create new roles
            $writeConnection->update('admin_role', ['role_name' => 'Super Admin'], "role_id = 3");
            $writeConnection->update('admin_role', ['parent_id' => '5'], "parent_id = 3");
            $writeConnection->insert('admin_role', ['role_id' => '5', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QC Manager', 'gws_is_all' => '1']);

            $writeConnection->update('admin_role', ['role_name' => 'QC Inspector'], "role_id = 7");

            $writeConnection->update('admin_role', ['role_name' => 'QC Admin'], "role_id = 16");
            $writeConnection->update('admin_role', ['role_id' => '4'], "role_id = 16");
            $writeConnection->update('admin_role', ['parent_id' => '4'], "parent_id = 16");

            $writeConnection->update('admin_role', ['role_name' => 'QC Deputy Manager'], "role_id = 142");
            $writeConnection->update('admin_role', ['role_id' => '6'], "role_id = 142");
            $writeConnection->update('admin_role', ['parent_id' => '6'], "parent_id = 142");

            //create new roles for QA
            $writeConnection->insert('admin_role', ['role_id' => '8', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Admin', 'gws_is_all' => '1']);
            $writeConnection->insert('admin_role', ['role_id' => '9', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Manager', 'gws_is_all' => '1']);
            $writeConnection->insert('admin_role', ['role_id' => '10', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Deputy Manager', 'gws_is_all' => '1']);
            $writeConnection->insert('admin_role', ['role_id' => '11', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Auditor', 'gws_is_all' => '1']);


            //Team leader roles
            $writeConnection->insert('admin_role', ['role_id' => '12', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QC Team Leader', 'gws_is_all' => '1']);
            $writeConnection->insert('admin_role', ['role_id' => '13', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Team Leader', 'gws_is_all' => '1']);


            //QA Inspector - Muong Muong
            $writeConnection->insert('admin_role', ['role_id' => '14', 'parent_id' => '0', 'tree_level' => '1', 'sort_order' => '0', 'role_type' => 'G', 'user_id' => '0', 'role_name' => 'QA Inspector', 'gws_is_all' => '1']);

            //now add role resources



            echo "Removing unused roles... \n";

            $writeConnection->delete('admin_role',  "role_id IN(221,317,318,319)");



            echo "Updating Report Setting... \n";
            $writeConnection->update('bs_report_setting', ['code' => 'ir'], "`code` = 'investigation'");
            $writeConnection->update('bs_report_setting', ['code' => 'qr'], "`code` = 'qrqn'");
            $writeConnection->update('bs_report_setting', ['code' => 'drr'], "`code` = 'car'");


            echo "Done! \n";
        }



    }catch (Exception $e){
        echo $e->getMessage()."\n";
    }


}

function renameTable($writeConnection, $tables = []){
    if(count($tables)){
        foreach ($tables as $old => $new) {
            if($writeConnection->isTableExists($old)){
                $writeConnection->renameTable($old, $new);
            }

        }
    }
}

function refreshPage($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);



}

function disableCache(){
    $types = [
        'config',
        'layout',
        'block_html',
        'translate',
        'collections',
    ];
    $allTypes = Mage::app()->useCache();

    $updatedTypes = 0;
    foreach ($types as $code) {
        if (!empty($allTypes[$code])) {
            $allTypes[$code] = 0;
            $updatedTypes++;
        }
        $tags = Mage::app()->getCacheInstance()->cleanType($code);
    }
    if ($updatedTypes > 0) {
        Mage::app()->saveUseCache($allTypes);
        //$this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("%s cache type(s) disabled.", $updatedTypes));
    }
}

function enableCache()
{
    $types = [
        'config',
        'layout',
        'block_html',
        'translate',
        'collections',
    ];
    $allTypes = Mage::app()->useCache();

    $updatedTypes = 0;
    foreach ($types as $code) {
        if (empty($allTypes[$code])) {
            $allTypes[$code] = 1;
            $updatedTypes++;
        }
    }
    if ($updatedTypes > 0) {
        Mage::app()->saveUseCache($allTypes);
    }

}

function flushCache(){
    Mage::app()->cleanCache();
    Mage::app()->getCacheInstance()->flush();
}
