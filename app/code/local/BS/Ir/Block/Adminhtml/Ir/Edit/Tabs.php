<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir admin edit tabs
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Block_Adminhtml_Ir_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('ir_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_ir')->__('Ir'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Ir_Block_Adminhtml_Ir_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_ir',
            [
                'label'   => Mage::helper('bs_ir')->__('Ir'),
                'title'   => Mage::helper('bs_ir')->__('Ir'),
                'content' => $this->getLayout()->createBlock(
                    'bs_ir/adminhtml_ir_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

	    if($this->getIr()->getId()){
		    $this->addTab('general_info', [
			    'label'     => Mage::helper('bs_ncr')->__('Related Info'),
			    'content' => $this->getLayout()->createBlock(
				    'bs_ir/adminhtml_ir_edit_tab_info'
			    )
			                      ->toHtml()
            ]);
	    }



        $id = 0;
        if($this->getIr()->getId()){
            $id = $this->getIr()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'ir');

        $this->addTab(
            'qr',
            [
                'label' => Mage::helper('bs_ir')->__('QR (%s)', $countRelations['qr']),
                'url' => $this->getUrl('adminhtml/ir_ir/qrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        if($this->getIr()->getIsCoa()){
            $this->addTab(
                'coa',
                [
                    'label' => Mage::helper('bs_ir')->__('COA (%s)', $countRelations['coa']),
                    'url' => $this->getUrl('adminhtml/ir_ir/coas', ['_current' => true]),
                    'class' => 'ajax',
                ]
            );
        }


        return parent::_beforeToHtml();
    }

    /**
     * Retrieve ir entity
     *
     * @access public
     * @return BS_Ir_Model_Ir
     * @author Bui Phong
     */
    public function getIr()
    {
        return Mage::registry('current_ir');
    }
}
