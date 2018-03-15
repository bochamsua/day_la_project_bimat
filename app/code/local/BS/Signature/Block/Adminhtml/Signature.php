<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature admin block
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Block_Adminhtml_Signature extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_signature';
        $this->_blockGroup         = 'bs_signature';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_signature')->__('Signature');
        $this->_updateButton('add', 'label', Mage::helper('bs_signature')->__('Add Signature'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/signature/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
