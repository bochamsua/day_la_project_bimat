<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Aircraft admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Aircraft_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('aircraft_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Aircraft'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Aircraft_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_aircraft',
            [
                'label'   => Mage::helper('bs_misc')->__('Aircraft'),
                'title'   => Mage::helper('bs_misc')->__('Aircraft'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_aircraft_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve aircraft entity
     *
     * @access public
     * @return BS_Misc_Model_Aircraft
     * @author Bui Phong
     */
    public function getAircraft()
    {
        return Mage::registry('current_aircraft');
    }
}
