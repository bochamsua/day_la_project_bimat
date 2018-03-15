<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule admin edit tabs
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Block_Adminhtml_Schedule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('schedule_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_schedule')->__('Schedule'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Schedule_Block_Adminhtml_Schedule_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_schedule',
            array(
                'label'   => Mage::helper('bs_schedule')->__('Schedule'),
                'title'   => Mage::helper('bs_schedule')->__('Schedule'),
                'content' => $this->getLayout()->createBlock(
                    'bs_schedule/adminhtml_schedule_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve schedule entity
     *
     * @access public
     * @return BS_Schedule_Model_Schedule
     * @author Bui Phong
     */
    public function getSchedule()
    {
        return Mage::registry('current_schedule');
    }
}
