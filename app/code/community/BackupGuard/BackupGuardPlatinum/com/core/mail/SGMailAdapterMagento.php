<?php
require_once(SG_MAIL_PATH.'SGIMailAdapter.php');

class SGMailAdapterMagento implements SGIMailAdapter
{
    private $subject = '';
    private $from = '';
    private $to = '';
    private $templateName = '';
    private $templateVars = array();
    private static $defaultFrom = '';
    private static $defaultTo = '';

    public function send()
    {
        $templateId = $this->templateName;
        $templateId .= $this->templateVars['succeeded']?'_success':'_fail';
        $emailTemplate = Mage::getModel('core/email_template')->loadDefault($templateId);

        $vars = $this->templateVars;
        $emailTemplate->getProcessedTemplate($vars);

        $storeId = Mage::app()->getStore()->getStoreId();
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));

        $emailTemplate->setTemplateSubject($this->subject);
        $emailTemplate->send($this->to, $this->to, $vars);
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public static function setDefaultFrom($from)
    {
        self::$defaultFrom = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public static function setDefaultTo($to)
    {
        self::$defaultTo = $to;
    }

    public function setTemplate($name)
    {
        $this->templateName = $name;
    }

    public function setTemplateVariables($vars)
    {
        $this->templateVars = $vars;
    }
}