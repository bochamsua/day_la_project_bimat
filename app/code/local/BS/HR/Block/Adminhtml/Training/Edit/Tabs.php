<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Training admin edit tabs
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Training_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('training_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_hr')->__('Training'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Training_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_training',
            [
                'label'   => Mage::helper('bs_hr')->__('Training'),
                'title'   => Mage::helper('bs_hr')->__('Training'),
                'content' => $this->getLayout()->createBlock(
                    'bs_hr/adminhtml_training_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve training entity
     *
     * @access public
     * @return BS_HR_Model_Training
     * @author Bui Phong
     */
    public function getTraining()
    {
        return Mage::registry('current_training');
    }
}
