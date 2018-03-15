<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer admin block
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_customer';
        $this->_blockGroup         = 'bs_acreg';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_acreg')->__('Customer');
        $this->_updateButton('add', 'label', Mage::helper('bs_acreg')->__('Add Customer'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/customer/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
