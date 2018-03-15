<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule admin block
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Block_Adminhtml_Schedule extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_schedule';
        $this->_blockGroup         = 'bs_schedule';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_schedule')->__('Schedule');
        $this->_updateButton('add', 'label', Mage::helper('bs_schedule')->__('Add Schedule'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_sched/schedule/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
