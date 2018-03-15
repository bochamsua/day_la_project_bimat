<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data admin block
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Block_Adminhtml_Concession extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_concession';
        $this->_blockGroup         = 'bs_concession';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_concession')->__('Concession Data');
        $this->_updateButton('add', 'label', Mage::helper('bs_concession')->__('Add Concession Data'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/concession/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
