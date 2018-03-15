<?php
    require_once(dirname(__FILE__).'/../boot.php');
    require_once(SG_STORAGE_PATH.'SGDropboxStorage.php');

    if(isAjax())
    {
        SGConfig::set('SG_DROPBOX_ACCESS_TOKEN','');
        SGConfig::set('SG_DROPBOX_CONNECTION_STRING','');

        if(isset($_POST['cancel']))
        {
            die('{"success":1}');
        }
    }

    $dp = new SGDropboxStorage();
    $dp->connect();
    if($dp->isConnected())
    {
        header("Location: ".SG_CLOUD_REDIRECT_URL);
        exit();
    }