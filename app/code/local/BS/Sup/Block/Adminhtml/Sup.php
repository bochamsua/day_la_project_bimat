<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier admin block
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Block_Adminhtml_Sup extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_sup';
        $this->_blockGroup         = 'bs_sup';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_sup')->__('Supplier');
        $this->_updateButton('add', 'label', Mage::helper('bs_sup')->__('Add Supplier'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/sup/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
