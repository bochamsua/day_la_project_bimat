<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier admin block
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Block_Adminhtml_Tosup extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_tosup';
        $this->_blockGroup         = 'bs_tosup';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_tosup')->__('Tool Supplier');
        $this->_updateButton('add', 'label', Mage::helper('bs_tosup')->__('Add Tool Supplier'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/tosup/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
