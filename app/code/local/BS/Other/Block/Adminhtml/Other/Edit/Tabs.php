<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work admin edit tabs
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Block_Adminhtml_Other_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('other_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_other')->__('Other Work'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_other',
            [
                'label'   => Mage::helper('bs_other')->__('Other Work'),
                'title'   => Mage::helper('bs_other')->__('Other Work'),
                'content' => $this->getLayout()->createBlock(
                    'bs_other/adminhtml_other_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

        $id = 0;
        if($this->getOther()->getId()){
            $id = $this->getOther()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'other');

        $this->addTab(
            'ir',
            [
                'label' => Mage::helper('bs_other')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/other_other/irs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'ncr',
            [
                'label' => Mage::helper('bs_other')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/other_other/ncrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'drr',
            [
                'label' => Mage::helper('bs_other')->__('DRR (%s)', $countRelations['drr']),
                'url' => $this->getUrl('adminhtml/other_other/drrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );
        
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve other task entity
     *
     * @access public
     * @return BS_Other_Model_Other
     * @author Bui Phong
     */
    public function getOther()
    {
        return Mage::registry('current_other');
    }
}
