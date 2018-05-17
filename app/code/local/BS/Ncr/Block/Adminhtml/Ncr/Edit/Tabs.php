<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr admin edit tabs
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Block_Adminhtml_Ncr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('ncr_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_ncr')->__('NCR'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Ncr_Block_Adminhtml_Ncr_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {


        $this->addTab(
            'form_ncr',
            [
                'label'   => Mage::helper('bs_ncr')->__('NCR'),
                'title'   => Mage::helper('bs_ncr')->__('NCR'),
                'content' => $this->getLayout()->createBlock(
                    'bs_ncr/adminhtml_ncr_edit_tab_form'
                )
                ->toHtml(),
            ]
        );
	    if($this->getNcr()->getId()){
		    $this->addTab('general_info', [
			    'label'     => Mage::helper('bs_ncr')->__('Related Info'),
			    'content' => $this->getLayout()->createBlock(
				    'bs_ncr/adminhtml_ncr_edit_tab_info'
			    )
			                      ->toHtml()
            ]);
	    }

        $id = 0;
        if($this->getNcr()->getId()){
            $id = $this->getNcr()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'ncr');

        $this->addTab(
            'ir',
            [
                'label' => Mage::helper('bs_ncr')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/ncr_ncr/irs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );
        

        $this->addTab(
            'qr',
            [
                'label' => Mage::helper('bs_ncr')->__('QR (%s)', $countRelations['qr']),
                'url' => $this->getUrl('adminhtml/ncr_ncr/qrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        if($this->getNcr()->getNcrStatus() >= 3){//only visible after closed
            $this->addTab(
                'coa',
                [
                    'label' => Mage::helper('bs_ncr')->__('COA (%s)', $countRelations['coa']),
                    'url' => $this->getUrl('adminhtml/ncr_ncr/coas', ['_current' => true]),
                    'class' => 'ajax',
                ]
            );
        }


	    
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve ncr entity
     *
     * @access public
     * @return BS_Ncr_Model_Ncr
     * @author Bui Phong
     */
    public function getNcr()
    {
        return Mage::registry('current_ncr');
    }
}
