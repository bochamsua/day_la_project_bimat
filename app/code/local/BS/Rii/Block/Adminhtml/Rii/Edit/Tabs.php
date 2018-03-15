<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off admin edit tabs
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Block_Adminhtml_Rii_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('rii_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_rii')->__('RII Sign-off'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Rii_Block_Adminhtml_Rii_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_rii',
            array(
                'label'   => Mage::helper('bs_rii')->__('RII Sign-off'),
                'title'   => Mage::helper('bs_rii')->__('RII Sign-off'),
                'content' => $this->getLayout()->createBlock(
                    'bs_rii/adminhtml_rii_edit_tab_form'
                )
                ->toHtml(),
            )
        );


        $id = 0;
        if($this->getRii()->getId()){
            $id = $this->getRii()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'rii');

        $this->addTab(
            'ir',
            array(
                'label' => Mage::helper('bs_rii')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/rii_rii/irs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'ncr',
            array(
                'label' => Mage::helper('bs_rii')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/rii_rii/ncrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'qr',
            array(
                'label' => Mage::helper('bs_rii')->__('QR (%s)', $countRelations['qr']),
                'url' => $this->getUrl('adminhtml/rii_rii/qrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );
        
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve rii sign-off entity
     *
     * @access public
     * @return BS_Rii_Model_Rii
     * @author Bui Phong
     */
    public function getRii()
    {
        return Mage::registry('current_rii');
    }
}
