<?php

interface SGIMailAdapter
{
    public function send();
    public function setSubject($subject);
    public function setFrom($from);
    public static function setDefaultFrom($from);
    public function setTo($to);
    public static function setDefaultTo($to);
    public function setTemplate($name);
    public function setTemplateVariables($vars);
}