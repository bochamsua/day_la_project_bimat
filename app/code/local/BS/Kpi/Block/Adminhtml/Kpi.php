<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data admin block
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Block_Adminhtml_Kpi extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_kpi';
        $this->_blockGroup         = 'bs_kpi';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_kpi')->__('KPI Data');
        $this->_updateButton('add', 'label', Mage::helper('bs_kpi')->__('Add KPI Data'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/kpi/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
