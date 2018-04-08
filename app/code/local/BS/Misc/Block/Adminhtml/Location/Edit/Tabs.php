<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Location admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Location_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('location_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Location'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Location_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_location',
            [
                'label'   => Mage::helper('bs_misc')->__('Location'),
                'title'   => Mage::helper('bs_misc')->__('Location'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_location_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve location entity
     *
     * @access public
     * @return BS_Misc_Model_Location
     * @author Bui Phong
     */
    public function getLocation()
    {
        return Mage::registry('current_location');
    }
}
