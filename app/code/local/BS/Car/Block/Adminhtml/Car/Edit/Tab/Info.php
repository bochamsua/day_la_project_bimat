<?php

class BS_Car_Block_Adminhtml_Car_Edit_Tab_Info extends Mage_Adminhtml_Block_Template
{
    /**
     * Load Wysiwyg on demand and prepare layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bs_car/edit/tab/info.phtml');
    }


    public function getCar()
    {
        return Mage::registry('current_car');
    }





}
