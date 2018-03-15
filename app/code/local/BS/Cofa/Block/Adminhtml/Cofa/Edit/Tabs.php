<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data admin edit tabs
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Block_Adminhtml_Cofa_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('cofa_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_cofa')->__('CoA Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_cofa',
            array(
                'label'   => Mage::helper('bs_cofa')->__('CoA Data'),
                'title'   => Mage::helper('bs_cofa')->__('CoA Data'),
                'content' => $this->getLayout()->createBlock(
                    'bs_cofa/adminhtml_cofa_edit_tab_form'
                )
                ->toHtml(),
            )
        );

        $id = 0;
        if($this->getCofa()->getId()){
            $id = $this->getCofa()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'cofa');

        $this->addTab(
            'ir',
            array(
                'label' => Mage::helper('bs_cofa')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/cofa_cofa/irs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'ncr',
            array(
                'label' => Mage::helper('bs_cofa')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/cofa_cofa/ncrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'drr',
            array(
                'label' => Mage::helper('bs_cofa')->__('DRR (%s)', $countRelations['drr']),
                'url' => $this->getUrl('adminhtml/cofa_cofa/drrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cofa entity
     *
     * @access public
     * @return BS_Cofa_Model_Cofa
     * @author Bui Phong
     */
    public function getCofa()
    {
        return Mage::registry('current_cofa');
    }
}
