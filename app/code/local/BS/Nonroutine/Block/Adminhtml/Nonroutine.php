<?php
/**
 * BS_Nonroutine extension
 * 
 * @category       BS
 * @package        BS_Nonroutine
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Work Non-Routine admin block
 *
 * @category    BS
 * @package     BS_Nonroutine
 * @author Bui Phong
 */
class BS_Nonroutine_Block_Adminhtml_Nonroutine extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_nonroutine';
        $this->_blockGroup         = 'bs_nonroutine';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine');
        $this->_updateButton('add', 'label', Mage::helper('bs_nonroutine')->__('Add QC HAN Work Non-Routine'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_sched/nonroutine/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
