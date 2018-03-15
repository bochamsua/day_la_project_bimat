<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data admin edit tabs
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Block_Adminhtml_Kpi_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('kpi_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_kpi')->__('KPI Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Kpi_Block_Adminhtml_Kpi_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_kpi',
            array(
                'label'   => Mage::helper('bs_kpi')->__('KPI Data'),
                'title'   => Mage::helper('bs_kpi')->__('KPI Data'),
                'content' => $this->getLayout()->createBlock(
                    'bs_kpi/adminhtml_kpi_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve kpi data entity
     *
     * @access public
     * @return BS_Kpi_Model_Kpi
     * @author Bui Phong
     */
    public function getKpi()
    {
        return Mage::registry('current_kpi');
    }
}
