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
    echo "Auto mode \n";
    doMigration();
}


function doMigration(){
    try {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_read');

        if($readConnection->isTableExists('bs_drr_drr')){
            echo "Migration is already completed... \n";
            return;
        }else {
            echo "Updating all current records to QC HAN... \n";
            $allTypes = Mage::helper('bs_misc')->getAllTypes();
            foreach ($allTypes as $type) {
                $collection = Mage::getModel("bs_{$type}/{$type}")->getCollection();
                if($collection && $collection->count()){
                    foreach ($collection as $item) {
                        $item->setRegion(1)->setSection(1)->save();

                    }
                }
            }

            echo "Correcting DRR statuses... \n";
            $writeConnection->update("bs_drr_drr", ['drr_status' => 4], "drr_status = 2");

            echo "Correcting CAR statuses... \n";
            $writeConnection->update("bs_car_car", ['car_status' => 4], "car_status = 2");
            $writeConnection->update("bs_car_car", ['car_status' => 2], "car_status = 1");


            echo "Moving HAN Line Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHanLineIds = [];
            $surhanLine = Mage::getModel('bs_surveillance/line')->getCollection();
            if($surhanLine->count()){
                echo "Total {$surhanLine->count()} records found \n";
                foreach ($surhanLine as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 2;
                    $data['section'] = 1;
                    $data['region'] = 1;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHanLineIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];

                }
            }

            echo "Moving HAN Base Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHanBaseIds = [];
            $surhanBase = Mage::getModel('bs_surveillance/base')->getCollection();
            if($surhanBase->count()){
                echo "Total {$surhanBase->count()} records found \n";
                foreach ($surhanBase as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 1;
                    $data['section'] = 1;
                    $data['region'] = 1;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHanBaseIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }

            echo "Moving HAN CMC Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHanCmcIds = [];
            $surhanCmc = Mage::getModel('bs_surveillance/shop')->getCollection();
            if($surhanCmc->count()){
                echo "Total {$surhanCmc->count()} records found \n";
                foreach ($surhanCmc as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 10;
                    $data['section'] = 1;
                    $data['region'] = 1;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHanCmcIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }

            echo "Moving HAN CIMC Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHanCimcIds = [];
            $surhanCimc = Mage::getModel('bs_surveillance/cimc')->getCollection();
            if($surhanCimc->count()){
                echo "Total {$surhanCimc->count()} records found \n";
                foreach ($surhanCimc as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 6;
                    $data['section'] = 1;
                    $data['region'] = 1;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHanCimcIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }


            /**
             * 1 - Line
             * 2 - Base
             * 3 - CMC
             * 4 - CMR
             * 5 - C of A
             * 6 - RII Sign-off
             * 7 - Sign-off
             * 8 - IR
             * 9 - CIMC
             * 11- Concession
             */


            echo "Processing relations correction in HAN NCR... \n";

            $ncrHans = Mage::getModel('bs_ncr/ncr')->getCollection();
            foreach ($ncrHans as $ncr) {
                $taskGroupId = $ncr->getTaskgroupId();
                $relation = getRelation($taskGroupId, 'han');
                $refId = $ncr->getRefId();

                if($relation){
                    if(count($relation) == 2){//link to SUR
                        $relation1 = $relation[0];
                        $refType = $relation[1];
                        foreach (${$relation1} as $item) {
                            if($item['old'] == $refId){
                                $newRefId = $item['new'];
                                $link = Mage::getModel("bs_{$refType}/{$refType}")->load($newRefId);
                                $linkRefNo = $link->getRefNo();
                                echo "{$ncr->getRefNo()} -> link to: {$linkRefNo} \n";
                                $ncr->setRefId($newRefId)->setRefType($refType)->save();
                            }

                        }
                    }else {//link to other like CMR/Concession/RII/Signoff
                        $refType = $relation[0];
                        $link = Mage::getModel("bs_{$refType}/{$refType}")->load($ncr->getRefId());
                        $linkRefNo = $link->getRefNo();
                        echo "{$ncr->getRefNo()} -> link to: {$linkRefNo} \n";
                        $ncr->setRefType($refType)->save();
                    }

                }

            }

            echo "Processing relations correction in HAN DRR... \n";
            $drrHans = Mage::getModel('bs_drr/drr')->getCollection();
            foreach ($drrHans as $drr) {
                $taskGroupId = $drr->getTaskgroupId();
                $relation = getRelation($taskGroupId, 'han');
                $refId = $drr->getRefId();

                if($relation){
                    if(count($relation) == 2){//link to SUR
                        $relation1 = $relation[0];
                        $refType = $relation[1];
                        foreach (${$relation1} as $item) {
                            if($item['old'] == $refId){
                                $newRefId = $item['new'];
                                $link = Mage::getModel("bs_{$refType}/{$refType}")->load($newRefId);
                                $linkRefNo = $link->getRefNo();
                                echo "{$drr->getRefNo()} -> link to: {$linkRefNo} \n";
                                $drr->setRefId($newRefId)->setRefType($refType)->save();
                            }

                        }
                    }else {//link to other like CMR/Concession/RII/Signoff
                        $refType = $relation[0];
                        $link = Mage::getModel("bs_{$refType}/{$refType}")->load($drr->getRefId());
                        $linkRefNo = $link->getRefNo();
                        echo "{$drr->getRefNo()} -> link to: {$linkRefNo} \n";
                        $drr->setRefType($refType)->save();
                    }

                }

            }


            echo "Processing relations correction in HAN QR... \n";
            $qrHans = Mage::getModel('bs_qr/qr')->getCollection();
            foreach ($qrHans as $qr) {
                $taskGroupId = $qr->getTaskgroupId();
                $relation = getRelation($taskGroupId, 'han');
                $refId = $qr->getRefId();

                if($relation){
                    if(count($relation) == 2){//link to SUR
                        $relation1 = $relation[0];
                        $refType = $relation[1];
                        foreach (${$relation1} as $item) {
                            if($item['old'] == $refId){
                                $newRefId = $item['new'];
                                $link = Mage::getModel("bs_{$refType}/{$refType}")->load($newRefId);
                                $linkRefNo = $link->getRefNo();
                                echo "{$qr->getRefNo()} -> link to: {$linkRefNo} \n";
                                $qr->setRefId($newRefId)->setRefType($refType)->save();
                            }

                        }
                    }else {//link to other like CMR/Concession/RII/Signoff
                        $refType = $relation[0];
                        $link = Mage::getModel("bs_{$refType}/{$refType}")->load($qr->getRefId());
                        $linkRefNo = $link->getRefNo();
                        echo "{$qr->getRefNo()} -> link to: {$linkRefNo} \n";
                        $qr->setRefType($refType)->save();
                    }

                }

            }




            echo "Moving HCM NCR... \n";
            $ncrHcmIds = [];
            $ncrHcm = Mage::getModel('bs_ncrhcm/ncr')->getCollection();
            if($ncrHcm->count()){
                echo "Total {$ncrHcm->count()} records found \n";
                foreach ($ncrHcm as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $ncr = Mage::getModel('bs_ncr/ncr');
                    $ncr->addData($data);
                    $ncr->save();

                    $ncrHcmIds[] = [
                        'new' => $ncr->getId(),
                        'old' => $item->getId(),
                        'taskgroup_id' => $data['taskgroup_id'],
                        'ref_id'    => $data['ref_id']
                    ];//new => old

                }
            }

            //echo "Moving HCM DRR... \n";
            /*$drrHcmIds = [];
            $drrHcm = Mage::getModel('bs_drrhcm/car')->getCollection();
            if($drrHcm->count()){
                foreach ($drrHcm as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['drr_source'] = $data['car_source'];
                    $data['drr_type'] = $data['car_type'];
                    $data['drr_status'] = $data['car_status'];
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $drr = Mage::getModel('bs_drr/drr');
                    $drr->addData($data);
                    $drr->save();

                    //$drrIds[$item->getId()] = $drr->getId();//old => new data

                    $drrHcmIds[] = [
                        'new' => $drr->getId(),
                        'old' => $item->getId(),
                        'taskgroup_id' => $data['taskgroup_id'],
                        'ref_id'    => $data['ref_id']
                    ];//new => old

                }
            }*/

            echo "Moving HCM IR... \n";
            $irHcmIds = [];
            $irHcm = Mage::getModel('bs_irhcm/investigation')->getCollection();
            if($irHcm->count()){
                echo "Total {$irHcm->count()} records found \n";
                foreach ($irHcm as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['ir_status'] = $data['inv_status'];
                    $data['ir_source'] = $data['inv_source'];
                    $data['drr'] = $data['car'];
                    $data['qr'] = $data['qrqn'];
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $ir = Mage::getModel('bs_ir/ir');
                    $ir->addData($data);
                    $ir->save();

                    //$irIds[$item->getId()] = $ir->getId();//old => new data
                    $irHcmIds[] = [
                        'new' => $ir->getId(),
                        'old' => $item->getId(),
                        'taskgroup_id' => $data['taskgroup_id'],
                        'ref_id'    => $data['ref_id']
                    ];//new => old

                }
            }

            echo "Moving HCM RII... \n";
            $riiHcmIds = [];
            $riiHcm = Mage::getModel('bs_riihcm/rii')->getCollection();
            if($riiHcm->count()){
                echo "Total {$riiHcm->count()} records found \n";
                foreach ($riiHcm as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['ir'] = $data['investigation'];
                    $data['report_date'] = $data['inspection_date'];
                    $data['qr'] = $data['qrqn'];
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $rii = Mage::getModel('bs_rii/rii');
                    $rii->addData($data);
                    $rii->save();

                    //$riiIds[$item->getId()] = $rii->getId();//old => new data
                    $riiHcmIds[] = [
                        'new' => $rii->getId(),
                        'old' => $item->getId(),
                        'taskgroup_id' => $data['taskgroup_id'],
                        'ref_id'    => $data['ref_id']
                    ];//new => old

                }
            }

            echo "Moving HCM Sign-off... \n";
            $signoffHcmIds = [];
            $signoffHcm = Mage::getModel('bs_signoffhcm/signoff')->getCollection();
            if($signoffHcm->count()){
                echo "Total {$signoffHcm->count()} records found \n";
                foreach ($signoffHcm as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['ir'] = $data['investigation'];
                    $data['report_date'] = $data['inspection_date'];
                    $data['qr'] = $data['qrqn'];
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $signoff = Mage::getModel('bs_signoff/signoff');
                    $signoff->addData($data);
                    $signoff->save();

                    //$signoffIds[$item->getId()] = $signoff->getId();//old => new data
                    $signoffHcmIds[] = [
                        'new' => $signoff->getId(),
                        'old' => $item->getId(),
                        'taskgroup_id' => $data['taskgroup_id'],
                        'ref_id'    => $data['ref_id']
                    ];//new => old

                }
            }


            echo "Moving HCM Line Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHcmLineIds = [];
            $surhcmLine = Mage::getModel('bs_surhcm/line')->getCollection();
            if($surhcmLine->count()){
                echo "Total {$surhcmLine->count()} records found \n";
                foreach ($surhcmLine as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 4;
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHcmLineIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }

            echo "Moving HCM Base Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHcmBaseIds = [];
            $surhcmBase = Mage::getModel('bs_surhcm/base')->getCollection();
            if($surhcmBase->count()){
                echo "Total {$surhcmBase->count()} records found \n";
                foreach ($surhcmBase as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 3;
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHcmBaseIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }

            echo "Moving HCM CMC Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHcmCmcIds = [];
            $surhcmCmc = Mage::getModel('bs_surhcm/shop')->getCollection();
            if($surhcmCmc->count()){
                echo "Total {$surhcmCmc->count()} records found \n";
                foreach ($surhcmCmc as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 15;
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHcmCmcIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }

            echo "Moving HCM CIMC Surveillances... \n";
            //first we move data to new sur table, get the new id to update ncr/drr/qr/ir tables
            $surHcmCimcIds = [];
            $surhcmCimc = Mage::getModel('bs_surhcm/cimc')->getCollection();
            if($surhcmCimc->count()){
                echo "Total {$surhcmCimc->count()} records found \n";
                foreach ($surhcmCimc as $item) {
                    //unset ID to avoid duplicate IDs
                    $data = $item->getData();
                    $data['entity_id'] = null;
                    $data['report_date'] = $data['inspection_date'];
                    $data['ir'] = $data['investigation'];
                    $data['qr'] = $data['qrqn'];
                    $data['drr'] = $data['car'];
                    $data['dept_id'] = 6;
                    $data['section'] = 1;
                    $data['region'] = 2;

                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->addData($data);
                    $sur->save();

                    $surHcmCimcIds[] = [
                        'new' => $sur->getId(),
                        'old' => $item->getId(),
                    ];
                }
            }



            //echo "Processing relations between HCM NCR -> NCR... \n";
            /*foreach ($ncrHcmIds as $relation2) {
                if($relation2['taskgroup_id'] != 0){
                    $relation = getRelation($relation2['taskgroup_id'], 'hcm');
                    $refId = $relation2['ref_id'];
                    $oldId = $relation2['old'];
                    $newId = $relation2['new'];
                    if($relation){
                        $relation1 = $relation[0];
                        $refType = $relation[1];
                        foreach (${$relation1} as $item) {
                            if($item['old'] == $refId){
                                $newRefId = $item['new'];
                                $writeConnection->update('bs_ncr_ncr', ['ref_type' => $refType, 'ref_id' => $newRefId], "entity_id = {$newId}");
                            }

                        }
                    }
                }
            }*/

            //echo "Processing relations between HCM IR -> IR... \n";
            /*foreach ($irHcmIds as $relation2) {
                if($relation2['taskgroup_id'] != 0){
                    $relation = getRelation($relation2['taskgroup_id'], 'hcm');
                    $refId = $relation2['ref_id'];
                    $oldId = $relation2['old'];
                    $newId = $relation2['new'];
                    if($relation){
                        $relation1 = $relation[0];
                        $refType = $relation[1];
                        foreach (${$relation1} as $item) {
                            if($item['old'] == $refId){
                                $newRefId = $item['new'];
                                $writeConnection->update('bs_ir_ir', ['ref_type' => $refType, 'ref_id' => $newRefId], "entity_id = {$newId}");
                            }

                        }
                    }
                }
            }*/







            echo "Enabling Observation... \n";
            if(file_exists('app/etc/modules/BS_Observation.xml.bak')){
                exec("mv app/etc/modules/BS_Observation.xml.bak app/etc/modules/BS_Observation.xml");
            }







            echo "Enabling cache... \n";
            enableCache();

            echo "Flushing cache... \n";
            flushCache();

            echo "Done! \n";
        }



    }catch (Exception $e){
        echo $e->getMessage()."\n";
    }


}


function getRelation($taskGroupId, $region){
    if($taskGroupId == 1){
        if((!$region || $region == 'han')){
            return ['surHanLineIds', 'sur'];
        }else {
            return ['surHcmLineIds', 'sur'];
        }

    }elseif($taskGroupId == 2){
        if((!$region || $region == 'han')){
            return ['surHanBaseIds', 'sur'];
        }else {
            return ['surHcmBaseIds', 'sur'];
        }

    }elseif($taskGroupId == 3){
        if((!$region || $region == 'han')){
            return ['surHanCmcIds', 'sur'];
        }else {
            return ['surHcmCmcIds', 'sur'];
        }

    }elseif($taskGroupId == 4 && (!$region || $region == 'han') ){
        return ['cmr'];
    }elseif($taskGroupId == 5 && (!$region || $region == 'han') ){
        return ['cofa'];
    }elseif($taskGroupId == 6){
        if((!$region || $region == 'han')){
            return ['rii'];
        }else {
            return ['riiHcmIds', 'rii'];
        }
    }elseif($taskGroupId == 7){
        if((!$region || $region == 'han')){
            return ['signoff'];
        }else {
            return ['signoffHcmIds', 'signoff'];
        }
    }elseif($taskGroupId == 8){
        if((!$region || $region == 'han')){
            return ['ir'];
        }else {
            return ['irHcmIds', 'ir'];
        }
    }elseif($taskGroupId == 9){
        if((!$region || $region == 'han')){
            return ['surHanCimcIds', 'sur'];
        }else {
            return ['surHcmCimcIds', 'sur'];
        }
    }elseif($taskGroupId == 11){
        return ['concession'];
    }

    return false;
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
