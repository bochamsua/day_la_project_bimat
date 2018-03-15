<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report admin block
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Kpireport extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_kpireport';
        $this->_blockGroup         = 'bs_kpireport';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_kpireport')->__('KPI Report');
        $this->_updateButton('add', 'label', Mage::helper('bs_kpireport')->__('Add KPI Report'));

	    $this->_removeButton('add');

    }
}
