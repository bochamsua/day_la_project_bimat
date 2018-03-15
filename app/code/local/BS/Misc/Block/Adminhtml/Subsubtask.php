<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Sub Task admin block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subsubtask extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_subsubtask';
        $this->_blockGroup         = 'bs_misc';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_misc')->__('Survey Sub Sub Code');
        $this->_updateButton('add', 'label', Mage::helper('bs_misc')->__('Add Survey Sub Sub Codes'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subsubtask/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
