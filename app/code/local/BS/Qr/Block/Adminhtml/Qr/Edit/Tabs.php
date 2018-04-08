<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR admin edit tabs
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Block_Adminhtml_Qr_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('qr_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_qr')->__('QR'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Qr_Block_Adminhtml_Qr_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_qr',
            [
                'label'   => Mage::helper('bs_qr')->__('QR'),
                'title'   => Mage::helper('bs_qr')->__('QR'),
                'content' => $this->getLayout()->createBlock(
                    'bs_qr/adminhtml_qr_edit_tab_form'
                )
                ->toHtml(),
            ]
        );

	    if($this->getQr()->getId()){
		    $this->addTab('general_info', [
			    'label'     => Mage::helper('bs_qr')->__('Related Info'),
			    'content' => $this->getLayout()->createBlock(
				    'bs_qr/adminhtml_qr_edit_tab_info'
			    )
			                      ->toHtml()
            ]);
	    }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve qr entity
     *
     * @access public
     * @return BS_Qr_Model_Qr
     * @author Bui Phong
     */
    public function getQr()
    {
        return Mage::registry('current_qr');
    }
}
