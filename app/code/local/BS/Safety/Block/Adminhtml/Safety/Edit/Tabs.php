<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data admin edit tabs
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Block_Adminhtml_Safety_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('safety_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_safety')->__('Safety Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Safety_Block_Adminhtml_Safety_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_safety',
            array(
                'label'   => Mage::helper('bs_safety')->__('Safety Data'),
                'title'   => Mage::helper('bs_safety')->__('Safety Data'),
                'content' => $this->getLayout()->createBlock(
                    'bs_safety/adminhtml_safety_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve safety data entity
     *
     * @access public
     * @return BS_Safety_Model_Safety
     * @author Bui Phong
     */
    public function getSafety()
    {
        return Mage::registry('current_safety');
    }
}
