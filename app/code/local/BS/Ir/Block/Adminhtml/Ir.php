<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir admin block
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Block_Adminhtml_Ir extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_ir';
        $this->_blockGroup         = 'bs_ir';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_ir')->__('Ir');
        $this->_updateButton('add', 'label', Mage::helper('bs_ir')->__('Add Ir'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/ir/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
