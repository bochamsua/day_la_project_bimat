<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * MOR admin edit tabs
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Block_Adminhtml_Mor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('mor_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_mor')->__('MOR'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Mor_Block_Adminhtml_Mor_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_mor',
            [
                'label'   => Mage::helper('bs_mor')->__('MOR'),
                'title'   => Mage::helper('bs_mor')->__('MOR'),
                'content' => $this->getLayout()->createBlock(
                    'bs_mor/adminhtml_mor_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve mor entity
     *
     * @access public
     * @return BS_Mor_Model_Mor
     * @author Bui Phong
     */
    public function getMor()
    {
        return Mage::registry('current_mor');
    }
}
