<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code admin block
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncausegroup extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_ncausegroup';
        $this->_blockGroup         = 'bs_ncause';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_ncause')->__('Root Cause Code');
        $this->_updateButton('add', 'label', Mage::helper('bs_ncause')->__('Add Root Cause Code'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/ncausegroup/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
