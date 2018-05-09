<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car admin edit tabs
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Block_Adminhtml_Car_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('car_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_car')->__('Car'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Car_Block_Adminhtml_Car_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_car',
            [
                'label'   => Mage::helper('bs_car')->__('Car'),
                'title'   => Mage::helper('bs_car')->__('Car'),
                'content' => $this->getLayout()->createBlock(
                    'bs_car/adminhtml_car_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

        if($id = $this->getCar()->getId()){
            $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'car');

            $this->addTab('general_info', [
                'label'     => Mage::helper('bs_car')->__('Related Info'),
                'content' => $this->getLayout()->createBlock(
                    'bs_car/adminhtml_car_edit_tab_info'
                )
                    ->toHtml()
            ]);

            if($this->getCar()->getIsCoa()){
                $this->addTab(
                    'coa',
                    [
                        'label' => Mage::helper('bs_car')->__('COA (%s)', $countRelations['coa']),
                        'url' => $this->getUrl('adminhtml/car_car/coas', ['_current' => true]),
                        'class' => 'ajax',
                    ]
                );
            }

        }

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve car entity
     *
     * @access public
     * @return BS_Car_Model_Car
     * @author Bui Phong
     */
    public function getCar()
    {
        return Mage::registry('current_car');
    }
}
