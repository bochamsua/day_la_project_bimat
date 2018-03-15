<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data admin block
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Block_Adminhtml_Cmr extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_cmr';
        $this->_blockGroup         = 'bs_cmr';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_cmr')->__('CMR Data');
        $this->_updateButton('add', 'label', Mage::helper('bs_cmr')->__('Add CMR Data'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_data/cmr/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
