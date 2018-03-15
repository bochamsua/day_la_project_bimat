<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data admin block
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Block_Adminhtml_Cofa extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_cofa';
        $this->_blockGroup         = 'bs_cofa';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_cofa')->__('CoA Data');
        $this->_updateButton('add', 'label', Mage::helper('bs_cofa')->__('Add CoA Data'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/cofa/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
