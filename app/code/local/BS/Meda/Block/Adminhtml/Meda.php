<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA admin block
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Block_Adminhtml_Meda extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_meda';
        $this->_blockGroup         = 'bs_meda';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_meda')->__('MEDA');
        $this->_updateButton('add', 'label', Mage::helper('bs_meda')->__('Add MEDA'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/meda/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
