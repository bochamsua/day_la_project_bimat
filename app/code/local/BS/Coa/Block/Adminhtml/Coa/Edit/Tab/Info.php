<?php

class BS_Coa_Block_Adminhtml_Coa_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_coa/edit/tab/info.phtml');
    }


    public function getCoa()
    {
        return Mage::registry('current_coa');
    }





}
