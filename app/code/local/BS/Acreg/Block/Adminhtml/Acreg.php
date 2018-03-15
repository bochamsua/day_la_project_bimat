<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg admin block
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Acreg extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_acreg';
        $this->_blockGroup         = 'bs_acreg';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_acreg')->__('A/C Reg');
        $this->_updateButton('add', 'label', Mage::helper('bs_acreg')->__('Add A/C Reg'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/acreg/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
