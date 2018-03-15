<?php

class BS_Drr_Block_Adminhtml_Drr_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_drr/edit/tab/info.phtml');
    }


    public function getDrr()
    {
        return Mage::registry('current_drr');
    }





}
