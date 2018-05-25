<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action admin edit tabs
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Block_Adminhtml_Coa_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('coa_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_coa')->__('Corrective Action'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Coa_Block_Adminhtml_Coa_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_coa',
            [
                'label'   => Mage::helper('bs_coa')->__('Corrective Action'),
                'title'   => Mage::helper('bs_coa')->__('Corrective Action'),
                'content' => $this->getLayout()->createBlock(
                    'bs_coa/adminhtml_coa_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

        if($this->getCoa()->getId()){
            $this->addTab('general_info', [
                'label'     => Mage::helper('bs_coa')->__('Related Info'),
                'content' => $this->getLayout()->createBlock(
                    'bs_coa/adminhtml_coa_edit_tab_info'
                )
                    ->toHtml()
            ]);
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve corrective action entity
     *
     * @access public
     * @return BS_Coa_Model_Coa
     * @author Bui Phong
     */
    public function getCoa()
    {
        return Mage::registry('current_coa');
    }
}
