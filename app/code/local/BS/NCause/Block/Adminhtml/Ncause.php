<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause admin block
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncause extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_ncause';
        $this->_blockGroup         = 'bs_ncause';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_ncause')->__('Root Cause Sub Code');
        $this->_updateButton('add', 'label', Mage::helper('bs_ncause')->__('Add Root Cause Sub Code'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/ncause/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
