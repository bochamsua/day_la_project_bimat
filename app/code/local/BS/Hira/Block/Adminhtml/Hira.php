<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA admin block
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Block_Adminhtml_Hira extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_hira';
        $this->_blockGroup         = 'bs_hira';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_hira')->__('HIRA');
        $this->_updateButton('add', 'label', Mage::helper('bs_hira')->__('Add HIRA'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/hira/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
