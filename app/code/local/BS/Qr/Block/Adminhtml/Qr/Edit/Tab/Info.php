<?php

class BS_Qr_Block_Adminhtml_Qr_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_qr/edit/tab/info.phtml');
    }


    public function getQr()
    {
        return Mage::registry('current_qr');
    }





}
