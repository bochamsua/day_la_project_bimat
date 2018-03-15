<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate admin block
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Certificate extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_certificate';
        $this->_blockGroup         = 'bs_hr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_hr')->__('Certificate');
        $this->_updateButton('add', 'label', Mage::helper('bs_hr')->__('Add Certificate'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_hr/certificate/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
