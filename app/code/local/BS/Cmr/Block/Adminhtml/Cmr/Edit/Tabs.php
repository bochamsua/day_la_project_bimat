<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data admin edit tabs
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Block_Adminhtml_Cmr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('cmr_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_cmr')->__('CMR Data'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Cmr_Block_Adminhtml_Cmr_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_cmr',
            array(
                'label'   => Mage::helper('bs_cmr')->__('CMR Data'),
                'title'   => Mage::helper('bs_cmr')->__('CMR Data'),
                'content' => $this->getLayout()->createBlock(
                    'bs_cmr/adminhtml_cmr_edit_tab_form'
                )
                ->toHtml(),
            )
        );

        $id = 0;
        if($this->getCmr()->getId()){
            $id = $this->getCmr()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'cmr');

        $this->addTab(
            'ir',
            array(
                'label' => Mage::helper('bs_cmr')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/cmr_cmr/irs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'ncr',
            array(
                'label' => Mage::helper('bs_cmr')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/cmr_cmr/ncrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );

        $this->addTab(
            'drr',
            array(
                'label' => Mage::helper('bs_cmr')->__('DRR (%s)', $countRelations['drr']),
                'url' => $this->getUrl('adminhtml/cmr_cmr/drrs', array('_current' => true)),
                'class' => 'ajax',
            )
        );
        

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve cmr entity
     *
     * @access public
     * @return BS_Cmr_Model_Cmr
     * @author Bui Phong
     */
    public function getCmr()
    {
        return Mage::registry('current_cmr');
    }
}
