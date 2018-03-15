<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr admin block
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Block_Adminhtml_Drr extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_drr';
        $this->_blockGroup         = 'bs_drr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_drr')->__('Drr');
        $this->_updateButton('add', 'label', Mage::helper('bs_drr')->__('Add Drr'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/drr/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
