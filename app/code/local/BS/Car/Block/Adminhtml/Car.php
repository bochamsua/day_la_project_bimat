<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car admin block
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Block_Adminhtml_Car extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_car';
        $this->_blockGroup         = 'bs_car';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_car')->__('Car');
        $this->_updateButton('add', 'label', Mage::helper('bs_car')->__('Add Car'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/car/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
