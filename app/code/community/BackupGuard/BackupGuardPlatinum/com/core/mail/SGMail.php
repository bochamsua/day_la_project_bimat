<?php

class SGMail
{
    public static function create()
    {
        $className = 'SGMailAdapter'.SG_ENV_ADAPTER;
        require_once(SG_MAIL_PATH.$className.'.php');
        $adapter = new $className();
        return $adapter;
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }
}