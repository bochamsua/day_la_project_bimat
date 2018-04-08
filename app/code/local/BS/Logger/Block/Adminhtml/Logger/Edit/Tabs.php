<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger admin edit tabs
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Block_Adminhtml_Logger_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Bui Phong
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('logger_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_logger')->__('Logger'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Logger_Block_Adminhtml_Logger_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_logger',
            [
                'label'   => Mage::helper('bs_logger')->__('Logger'),
                'title'   => Mage::helper('bs_logger')->__('Logger'),
                'content' => $this->getLayout()->createBlock(
                    'bs_logger/adminhtml_logger_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve logger entity
     *
     * @access public
     * @return BS_Logger_Model_Logger
     * @author Bui Phong
     */
    public function getLogger()
    {
        return Mage::registry('current_logger');
    }
}
