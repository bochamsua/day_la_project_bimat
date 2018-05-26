<?php

class BS_Mor_Block_Adminhtml_Mor_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_mor/edit/tab/info.phtml');
    }


    public function getMor()
    {
        return Mage::registry('current_mor');
    }





}
