<?php

class BS_Qn_Block_Adminhtml_Qn_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_qn/edit/tab/info.phtml');
    }


    public function getQn()
    {
        return Mage::registry('current_qn');
    }





}
