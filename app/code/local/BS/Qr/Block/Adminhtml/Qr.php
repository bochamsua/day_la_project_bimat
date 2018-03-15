<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR admin block
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Block_Adminhtml_Qr extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_qr';
        $this->_blockGroup         = 'bs_qr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_qr')->__('QR');
        $this->_updateButton('add', 'label', Mage::helper('bs_qr')->__('Add QR'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/qr/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
