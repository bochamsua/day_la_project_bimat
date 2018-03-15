<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off admin block
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Block_Adminhtml_Signoff extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_signoff';
        $this->_blockGroup         = 'bs_signoff';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_signoff')->__('AC Sign-off');
        $this->_updateButton('add', 'label', Mage::helper('bs_signoff')->__('Add AC Sign-off'));


        $isAllowed = Mage::getSingleton('admin/session')->isAllowed("bs_work/signoff/new");
        if(!$isAllowed){
                $this->_removeButton('add');
        }

    }
}
