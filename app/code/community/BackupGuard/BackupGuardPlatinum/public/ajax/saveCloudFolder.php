<?php
    require_once(dirname(__FILE__).'/../boot.php');
    if(isAjax())
    {
        if(isset($_POST['cloudFolder']) && !empty($_POST['cloudFolder']))
        {
            $cloudFolderName = $_POST['cloudFolder'];
            SGConfig::set('SG_STORAGE_BACKUPS_FOLDER_NAME', $cloudFolderName);
            die('{"success":1}');
        }
        die('{"error":"Destination folder is required."}');
    }