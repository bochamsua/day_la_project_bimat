<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Training admin block
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Training extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_training';
        $this->_blockGroup         = 'bs_hr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_hr')->__('Training');
        $this->_updateButton('add', 'label', Mage::helper('bs_hr')->__('Add Training'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_hr/training/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
