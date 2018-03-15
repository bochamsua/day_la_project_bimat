<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr admin edit tabs
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Block_Adminhtml_Drr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('drr_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_drr')->__('Drr'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Drr_Block_Adminhtml_Drr_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_drr',
            array(
                'label'   => Mage::helper('bs_drr')->__('Drr'),
                'title'   => Mage::helper('bs_drr')->__('Drr'),
                'content' => $this->getLayout()->createBlock(
                    'bs_drr/adminhtml_drr_edit_tab_form'
                )
                ->toHtml(),
            )
        );

        if($this->getDrr()->getId()){
            $this->addTab('general_info', array(
                'label'     => Mage::helper('bs_drr')->__('Related Info'),
                'content' => $this->getLayout()->createBlock(
                    'bs_drr/adminhtml_drr_edit_tab_info'
                )
                    ->toHtml()
            ));
        }

        $id = 0;
        if($this->getDrr()->getId()){
            $id = $this->getDrr()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'drr');

        $this->addTab(
            'ir',
            array(
                'label' => Mage::helper('bs_drr')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/drr_drr/irs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'ncr',
            array(
                'label' => Mage::helper('bs_drr')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/drr_drr/ncrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve drr entity
     *
     * @access public
     * @return BS_Drr_Model_Drr
     * @author Bui Phong
     */
    public function getDrr()
    {
        return Mage::registry('current_drr');
    }
}
