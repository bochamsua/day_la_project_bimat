<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority admin block
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Block_Adminhtml_Aut extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_aut';
        $this->_blockGroup         = 'bs_aut';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_aut')->__('Authority');
        $this->_updateButton('add', 'label', Mage::helper('bs_aut')->__('Add Authority'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/aut/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
