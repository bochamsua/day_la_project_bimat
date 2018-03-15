<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code admin edit tabs
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncausegroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('ncausegroup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_ncause')->__('Root Cause Code'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_ncausegroup',
            array(
                'label'   => Mage::helper('bs_ncause')->__('Root Cause Code'),
                'title'   => Mage::helper('bs_ncause')->__('Root Cause Code'),
                'content' => $this->getLayout()->createBlock(
                    'bs_ncause/adminhtml_ncausegroup_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cause group entity
     *
     * @access public
     * @return BS_NCause_Model_Ncausegroup
     * @author Bui Phong
     */
    public function getNcausegroup()
    {
        return Mage::registry('current_ncausegroup');
    }
}
