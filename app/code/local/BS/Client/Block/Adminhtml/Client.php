<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client admin block
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Block_Adminhtml_Client extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_client';
        $this->_blockGroup         = 'bs_client';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_client')->__('Client');
        $this->_updateButton('add', 'label', Mage::helper('bs_client')->__('Add Client'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/client/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
