<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data admin edit tabs
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Block_Adminhtml_Concession_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('concession_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_concession')->__('Concession Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_concession',
            [
                'label'   => Mage::helper('bs_concession')->__('Concession Data'),
                'title'   => Mage::helper('bs_concession')->__('Concession Data'),
                'content' => $this->getLayout()->createBlock(
                    'bs_concession/adminhtml_concession_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

        $id = 0;
        if($this->getConcession()->getId()){
            $id = $this->getConcession()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'concession');

        $this->addTab(
            'ir',
            [
                'label' => Mage::helper('bs_concession')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/concession_concession/irs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'ncr',
            [
                'label' => Mage::helper('bs_concession')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/concession_concession/ncrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'drr',
            [
                'label' => Mage::helper('bs_concession')->__('DRR (%s)', $countRelations['drr']),
                'url' => $this->getUrl('adminhtml/concession_concession/drrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve concession entity
     *
     * @access public
     * @return BS_Concession_Model_Concession
     * @author Bui Phong
     */
    public function getConcession()
    {
        return Mage::registry('current_concession');
    }
}
