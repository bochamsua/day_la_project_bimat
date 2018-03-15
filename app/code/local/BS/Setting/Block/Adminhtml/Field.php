<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance admin block
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Block_Adminhtml_Field extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_field';
        $this->_blockGroup         = 'bs_setting';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_setting')->__('Field Dependance');
        $this->_updateButton('add', 'label', Mage::helper('bs_setting')->__('Add Field Dependance'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("system/field/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
