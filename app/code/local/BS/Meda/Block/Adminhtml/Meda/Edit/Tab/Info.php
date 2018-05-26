<?php

class BS_Meda_Block_Adminhtml_Meda_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_meda/edit/tab/info.phtml');
    }


    public function getMeda()
    {
        return Mage::registry('current_meda');
    }





}
