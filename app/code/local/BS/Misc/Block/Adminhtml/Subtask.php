<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task admin block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subtask extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_subtask';
        $this->_blockGroup         = 'bs_misc';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_misc')->__('Survey Sub Code');
        $this->_updateButton('add', 'label', Mage::helper('bs_misc')->__('Add Survey Sub Codes'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subtask/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
