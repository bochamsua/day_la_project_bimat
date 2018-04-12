<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Non-routine Work admin block
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Block_Adminhtml_Nrw extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_nrw';
        $this->_blockGroup         = 'bs_nrw';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_nrw')->__('Non-routine Work');
        $this->_updateButton('add', 'label', Mage::helper('bs_nrw')->__('Add Non-routine Work'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_sched/nrw/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
