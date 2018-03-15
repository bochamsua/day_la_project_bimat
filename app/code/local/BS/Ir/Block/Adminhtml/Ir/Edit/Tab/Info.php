<?php

class BS_Ir_Block_Adminhtml_Ir_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_ir/edit/tab/info.phtml');
    }


    public function getIr()
    {
        return Mage::registry('current_ir');
    }





}
