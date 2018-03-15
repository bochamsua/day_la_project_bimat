<?php

class BS_Ncr_Block_Adminhtml_Ncr_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_ncr/edit/tab/info.phtml');
    }


    public function getNcr()
    {
        return Mage::registry('current_ncr');
    }





}
