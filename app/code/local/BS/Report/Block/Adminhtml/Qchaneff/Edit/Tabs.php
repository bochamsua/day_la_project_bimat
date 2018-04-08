<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation admin edit tabs
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Qchaneff_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('qchaneff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_report')->__('QC HAN Evaluation'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_qchaneff',
            [
                'label'   => Mage::helper('bs_report')->__('QC HAN Evaluation'),
                'title'   => Mage::helper('bs_report')->__('QC HAN Evaluation'),
                'content' => $this->getLayout()->createBlock(
                    'bs_report/adminhtml_qchaneff_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve qc han efficiency entity
     *
     * @access public
     * @return BS_Report_Model_Qchaneff
     * @author Bui Phong
     */
    public function getQchaneff()
    {
        return Mage::registry('current_qchaneff');
    }
}
