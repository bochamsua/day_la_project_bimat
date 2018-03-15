<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance admin block
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Block_Adminhtml_Sur extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_sur';
        $this->_blockGroup         = 'bs_sur';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_sur')->__('Surveillance');
        $this->_updateButton('add', 'label', Mage::helper('bs_sur')->__('Add Surveillance'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/sur/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
