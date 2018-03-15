<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off admin block
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Block_Adminhtml_Rii extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_rii';
        $this->_blockGroup         = 'bs_rii';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_rii')->__('RII Sign-off');
        $this->_updateButton('add', 'label', Mage::helper('bs_rii')->__('Add RII Sign-off'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/rii/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
