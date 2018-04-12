<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Non-routine Work admin edit tabs
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Block_Adminhtml_Nrw_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('nrw_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_nrw')->__('Non-routine Work'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Nrw_Block_Adminhtml_Nrw_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_nrw',
            [
                'label'   => Mage::helper('bs_nrw')->__('Non-routine Work'),
                'title'   => Mage::helper('bs_nrw')->__('Non-routine Work'),
                'content' => $this->getLayout()->createBlock(
                    'bs_nrw/adminhtml_nrw_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve non-routine work entity
     *
     * @access public
     * @return BS_Nrw_Model_Nrw
     * @author Bui Phong
     */
    public function getNrw()
    {
        return Mage::registry('current_nrw');
    }
}
