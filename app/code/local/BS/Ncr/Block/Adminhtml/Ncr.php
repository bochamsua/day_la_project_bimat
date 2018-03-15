<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr admin block
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Block_Adminhtml_Ncr extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_ncr';
        $this->_blockGroup         = 'bs_ncr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_ncr')->__('NCR');
        $this->_updateButton('add', 'label', Mage::helper('bs_ncr')->__('Add NCR'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/ncr/new");
        if(!$isAllowed){
            $this->_removeButton('add');
        }

    }
}
