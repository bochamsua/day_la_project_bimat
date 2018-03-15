<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate Type admin block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Certtype extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_certtype';
        $this->_blockGroup         = 'bs_misc';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_misc')->__('Certificate Type');
        $this->_updateButton('add', 'label', Mage::helper('bs_misc')->__('Add Certificate Type'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_misc/certtype/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
