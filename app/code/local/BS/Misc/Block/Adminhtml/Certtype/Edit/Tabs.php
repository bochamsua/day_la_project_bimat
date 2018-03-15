<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate Type admin edit tabs
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Certtype_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('certtype_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_misc')->__('Certificate Type'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Certtype_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_certtype',
            array(
                'label'   => Mage::helper('bs_misc')->__('Certificate Type'),
                'title'   => Mage::helper('bs_misc')->__('Certificate Type'),
                'content' => $this->getLayout()->createBlock(
                    'bs_misc/adminhtml_certtype_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve certificate type entity
     *
     * @access public
     * @return BS_Misc_Model_Certtype
     * @author Bui Phong
     */
    public function getCerttype()
    {
        return Mage::registry('current_certtype');
    }
}
