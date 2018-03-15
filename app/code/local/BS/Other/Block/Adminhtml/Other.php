<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work admin block
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Block_Adminhtml_Other extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_other';
        $this->_blockGroup         = 'bs_other';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_other')->__('Other Work');
        $this->_updateButton('add', 'label', Mage::helper('bs_other')->__('Add Other Work'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/other/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
