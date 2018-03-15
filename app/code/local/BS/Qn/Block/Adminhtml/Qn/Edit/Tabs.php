<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN admin edit tabs
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Block_Adminhtml_Qn_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('qn_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_qn')->__('QN'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Qn_Block_Adminhtml_Qn_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_qn',
            array(
                'label'   => Mage::helper('bs_qn')->__('QN'),
                'title'   => Mage::helper('bs_qn')->__('QN'),
                'content' => $this->getLayout()->createBlock(
                    'bs_qn/adminhtml_qn_edit_tab_form'
                )
                ->toHtml(),
            )
        );

	    if($this->getQn()->getId()){
		    $this->addTab('general_info', array(
			    'label'     => Mage::helper('bs_qn')->__('Related Info'),
			    'content' => $this->getLayout()->createBlock(
				    'bs_qn/adminhtml_qn_edit_tab_info'
			    )
			                      ->toHtml()
		    ));
	    }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve qn entity
     *
     * @access public
     * @return BS_Qn_Model_Qn
     * @author Bui Phong
     */
    public function getQn()
    {
        return Mage::registry('current_qn');
    }
}
