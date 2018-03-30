<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data admin block
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Block_Adminhtml_Safety extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_safety';
        $this->_blockGroup         = 'bs_safety';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_safety')->__('Safety Data');
        $this->_updateButton('add', 'label', Mage::helper('bs_safety')->__('Add Safety Data'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/safety/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
