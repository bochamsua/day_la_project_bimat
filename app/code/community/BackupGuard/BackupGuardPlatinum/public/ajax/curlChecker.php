<?php
    require_once(dirname(__FILE__).'/../boot.php');
    if(isAjax())
    {
        try
        {
            SGBoot::checkRequirement('curl');
            die('{"success":1}');
        }
        catch(SGException $exception)
        {
            die('{"error":"'.$exception->getMessage().'"}');
        }
    }