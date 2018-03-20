<?php
chdir(getcwd());
//require_once 'simple_html_dom.php';
require_once 'app/Mage.php';

umask(0);
Mage::app();

$storeId = '0';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


if(!isset($argv[1])){
    echo "Please specify the path \n";
}else {
    $path = $argv[1];
    $rdi = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::KEY_AS_PATHNAME);
    foreach (new RecursiveIteratorIterator($rdi, RecursiveIteratorIterator::SELF_FIRST) as $file => $info) {
        if(!$info->isDir()){
            //echo $file."\n";
            $res = Mage::helper('bs_misc/image')->resizeImage($info->getRealPath());
            if($res){
                echo "Done {$file} \n";
                file_put_contents("resized-images.txt", $file . "\r\n", FILE_APPEND);
            }
        }

    }
}
