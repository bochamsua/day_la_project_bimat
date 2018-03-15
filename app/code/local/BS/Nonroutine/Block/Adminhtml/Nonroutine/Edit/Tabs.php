<?php
/**
 * BS_Nonroutine extension
 * 
 * @category       BS
 * @package        BS_Nonroutine
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Work Non-Routine admin edit tabs
 *
 * @category    BS
 * @package     BS_Nonroutine
 * @author Bui Phong
 */
class BS_Nonroutine_Block_Adminhtml_Nonroutine_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('nonroutine_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Nonroutine_Block_Adminhtml_Nonroutine_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_nonroutine',
            array(
                'label'   => Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine'),
                'title'   => Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine'),
                'content' => $this->getLayout()->createBlock(
                    'bs_nonroutine/adminhtml_nonroutine_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve qc han work non-routine entity
     *
     * @access public
     * @return BS_Nonroutine_Model_Nonroutine
     * @author Bui Phong
     */
    public function getNonroutine()
    {
        return Mage::registry('current_nonroutine');
    }
}
