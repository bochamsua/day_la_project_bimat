<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action admin block
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Block_Adminhtml_Coa extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_coa';
        $this->_blockGroup         = 'bs_coa';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_coa')->__('Corrective Action');
        $this->_updateButton('add', 'label', Mage::helper('bs_coa')->__('Add Corrective Action'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/coa/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
