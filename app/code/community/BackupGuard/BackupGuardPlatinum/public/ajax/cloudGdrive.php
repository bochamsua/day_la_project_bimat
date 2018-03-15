<?php
    require_once(dirname(__FILE__).'/../boot.php');
    require_once(SG_STORAGE_PATH.'SGGoogleDriveStorage.php');

    @session_start();
    unset($_SESSION['sg_google_drive_access_token']);
    unset($_SESSION['sg_google_drive_expiration_ts']);

    if(isAjax())
    {
        SGConfig::set('SG_GOOGLE_DRIVE_REFRESH_TOKEN','');
        SGConfig::set('SG_GOOGLE_DRIVE_CONNECTION_STRING','');

        if(isset($_POST['cancel']))
        {
            die('{"success":1}');
        }
    }

    $dp = new SGGoogleDriveStorage();

    $dp->connect();
    if($dp->isConnected())
    {
        header("Location: ".SG_CLOUD_REDIRECT_URL);
        exit();
    }