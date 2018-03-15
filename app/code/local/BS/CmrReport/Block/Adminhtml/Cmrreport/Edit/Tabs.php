<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report admin edit tabs
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Block_Adminhtml_Cmrreport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('cmrreport_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_cmrreport')->__('CMR Report'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_cmrreport',
            array(
                'label'   => Mage::helper('bs_cmrreport')->__('CMR Report'),
                'title'   => Mage::helper('bs_cmrreport')->__('CMR Report'),
                'content' => $this->getLayout()->createBlock(
                    'bs_cmrreport/adminhtml_cmrreport_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cmr report entity
     *
     * @access public
     * @return BS_CmrReport_Model_Cmrreport
     * @author Bui Phong
     */
    public function getCmrreport()
    {
        return Mage::registry('current_cmrreport');
    }
}
