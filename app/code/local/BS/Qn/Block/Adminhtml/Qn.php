<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN admin block
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Block_Adminhtml_Qn extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_qn';
        $this->_blockGroup         = 'bs_qn';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_qn')->__('QN');
        $this->_updateButton('add', 'label', Mage::helper('bs_qn')->__('Add QN'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/qn/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
