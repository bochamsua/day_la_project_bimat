<?php
    require_once(dirname(__FILE__).'/../boot.php');
    require_once(SG_STORAGE_PATH.'SGFTPStorage.php');

    if(isAjax() && count($_POST))
    {

        if(isset($_POST['cancel']))
        {
            SGConfig::set('SG_FTP_HOST',false);
            SGConfig::set('SG_FTP_PORT',false);
            SGConfig::set('SG_FTP_USER',false);
            SGConfig::set('SG_FTP_PASSWORD',false);
            SGConfig::set('SG_FTP_ROOT_FOLDER',false);
            SGConfig::set('SG_STORAGE_FTP_CONNECTED',false);
            SGConfig::set('SG_FTP_CONNECTION_STRING',false);
            die('{"success":1}');
        }

        $options = $_POST;
        $error = array();
        $success = array('success'=>1);

        if(!isset($options['ftpHost']))
        {
            array_push($error,_t('',true));
        }
        if(!isset($options['ftpHost']))
        {
            array_push($error,_t('Host field is required.',true));
        }
        if(!isset($options['ftpPort']))
        {
            array_push($error,_t('Port field is required.',true));
        }
        if(!isset($options['ftpUser']))
        {
            array_push($error,_t('User field is required.',true));
        }
        if(!isset($options['ftpPass']))
        {
            array_push($error,_t('Password field is required.',true));
        }
        if(!isset($options['ftpRoot']))
        {
            array_push($error,_t('Root directory field is required.',true));
        }

        //If there are errors do not continue
        if(count($error))
        {
            die(json_encode($error));
        }

        //Try to connect
        try
        {
            SGConfig::set('SG_FTP_HOST',$options['ftpHost']);
            SGConfig::set('SG_FTP_PORT',$options['ftpPort']);
            SGConfig::set('SG_FTP_USER',$options['ftpUser']);
            SGConfig::set('SG_FTP_PASSWORD',$options['ftpPass']);
            SGConfig::set('SG_FTP_ROOT_FOLDER',$options['ftpRoot']);
            $ftp = new SGFTPStorage();
            $ftp->connect();
            SGConfig::set('SG_STORAGE_FTP_CONNECTED',true);
            die(json_encode($success));
        }
        catch(SGException $exception)
        {
            array_push($error,$exception->getMessage());
            die(json_encode($error));
        }
    }
