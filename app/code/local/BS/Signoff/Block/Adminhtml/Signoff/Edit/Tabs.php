<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off admin edit tabs
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Block_Adminhtml_Signoff_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('signoff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_signoff')->__('AC Sign-off'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_signoff',
            [
                'label'   => Mage::helper('bs_signoff')->__('AC Sign-off'),
                'title'   => Mage::helper('bs_signoff')->__('AC Sign-off'),
                'content' => $this->getLayout()->createBlock(
                    'bs_signoff/adminhtml_signoff_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

        $id = 0;
        if($this->getSignoff()->getId()){
            $id = $this->getSignoff()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'signoff');

        $this->addTab(
            'ir',
            [
                'label' => Mage::helper('bs_signoff')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/signoff_signoff/irs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'ncr',
            [
                'label' => Mage::helper('bs_signoff')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/signoff_signoff/ncrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'qr',
            [
                'label' => Mage::helper('bs_signoff')->__('QR (%s)', $countRelations['qr']),
                'url' => $this->getUrl('adminhtml/signoff_signoff/qrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );
        
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve sign-off entity
     *
     * @access public
     * @return BS_Signoff_Model_Signoff
     * @author Bui Phong
     */
    public function getSignoff()
    {
        return Mage::registry('current_signoff');
    }
}
