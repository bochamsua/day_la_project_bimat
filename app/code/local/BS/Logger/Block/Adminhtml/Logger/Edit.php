<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger admin edit form
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Block_Adminhtml_Logger_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        parent::__construct();
        $this->_blockGroup = 'bs_logger';
        $this->_controller = 'adminhtml_logger';

        $this->_removeButton('save');
        $this->_removeButton('saveandcontinue');
        $this->_removeButton('delete');
        $this->_removeButton('reset');

    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_logger') && Mage::registry('current_logger')->getId()) {
            return Mage::helper('bs_logger')->__(
                "View Logger",
                $this->escapeHtml(Mage::registry('current_logger')->getUserId())
            );
        } else {
            return Mage::helper('bs_logger')->__('Add Logger');
        }
    }
    public function getSaveAndContinueUrl()
        {
            return $this->getUrl('*/*/save', [
                '_current'   => true,
                'back'       => 'edit',
                'tab'        => '{{tab_id}}',
                'active_tab' => null
            ]);
        }
    public function getSelectedTabId()
        {
            return addslashes(htmlspecialchars($this->getRequest()->getParam('tab')));
        }
}
