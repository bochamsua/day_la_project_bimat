<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report admin block
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Block_Adminhtml_Routine extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_routine';
        $this->_blockGroup         = 'bs_routine';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_routine')->__('Routine Report');
        $this->_updateButton('add', 'label', Mage::helper('bs_routine')->__('Add Routine Report'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_report/routine/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
