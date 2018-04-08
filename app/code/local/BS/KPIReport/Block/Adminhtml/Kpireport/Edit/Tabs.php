<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report admin edit tabs
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Kpireport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('kpireport_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_kpireport')->__('KPI Report'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_kpireport',
            [
                'label'   => Mage::helper('bs_kpireport')->__('KPI Report'),
                'title'   => Mage::helper('bs_kpireport')->__('KPI Report'),
                'content' => $this->getLayout()->createBlock(
                    'bs_kpireport/adminhtml_kpireport_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve kpi report entity
     *
     * @access public
     * @return BS_KPIReport_Model_Kpireport
     * @author Bui Phong
     */
    public function getKpireport()
    {
        return Mage::registry('current_kpireport');
    }
}
