<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA admin edit tabs
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Block_Adminhtml_Hira_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('hira_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_hira')->__('HIRA'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Hira_Block_Adminhtml_Hira_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_hira',
            [
                'label'   => Mage::helper('bs_hira')->__('HIRA'),
                'title'   => Mage::helper('bs_hira')->__('HIRA'),
                'content' => $this->getLayout()->createBlock(
                    'bs_hira/adminhtml_hira_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve hira entity
     *
     * @access public
     * @return BS_Hira_Model_Hira
     * @author Bui Phong
     */
    public function getHira()
    {
        return Mage::registry('current_hira');
    }
}
