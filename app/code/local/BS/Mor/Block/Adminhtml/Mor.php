<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * MOR admin block
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Block_Adminhtml_Mor extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_mor';
        $this->_blockGroup         = 'bs_mor';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_mor')->__('MOR');
        $this->_updateButton('add', 'label', Mage::helper('bs_mor')->__('Add MOR'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/mor/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
