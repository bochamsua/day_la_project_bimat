<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Work Day admin block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Workday extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_workday';
        $this->_blockGroup         = 'bs_report';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_report')->__('Work Day');
        $this->_updateButton('add', 'label', Mage::helper('bs_report')->__('Add Work Day'));

		$this->_removeButton('add');
        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/workday/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }


}
