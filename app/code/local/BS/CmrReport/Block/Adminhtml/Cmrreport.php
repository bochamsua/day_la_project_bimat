<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report admin block
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Block_Adminhtml_Cmrreport extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_cmrreport';
        $this->_blockGroup         = 'bs_cmrreport';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_cmrreport')->__('CMR Report');
        $this->_updateButton('add', 'label', Mage::helper('bs_cmrreport')->__('Add CMR Report'));


        $this->_removeButton('add');

    }
}
