<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Export admin edit form
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Block_Adminhtml_Ex_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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

        $this->removeButton('back')
            ->removeButton('reset')
            ->removeButton('save');
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
        return Mage::helper('bs_imex')->__('Export');
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
