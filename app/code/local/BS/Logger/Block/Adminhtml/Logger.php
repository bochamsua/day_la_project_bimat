<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger admin block
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Block_Adminhtml_Logger extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_logger';
        $this->_blockGroup         = 'bs_logger';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_logger')->__('Logger');
        $this->_updateButton('add', 'label', Mage::helper('bs_logger')->__('Add Logger'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("system/logger/new");
        $this->_removeButton('add');

    }
}
