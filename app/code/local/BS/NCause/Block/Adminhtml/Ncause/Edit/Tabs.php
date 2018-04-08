<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause admin edit tabs
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncause_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('ncause_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_ncause')->__('Root Cause Sub Code'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncause_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_ncause',
            [
                'label'   => Mage::helper('bs_ncause')->__('Root Cause Sub Code'),
                'title'   => Mage::helper('bs_ncause')->__('Root Cause Sub Code'),
                'content' => $this->getLayout()->createBlock(
                    'bs_ncause/adminhtml_ncause_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cause entity
     *
     * @access public
     * @return BS_NCause_Model_Ncause
     * @author Bui Phong
     */
    public function getNcause()
    {
        return Mage::registry('current_ncause');
    }
}
