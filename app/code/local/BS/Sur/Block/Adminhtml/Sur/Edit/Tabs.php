<?php
/**
 * BS_Sur extension
 *
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */

/**
 * Surveillance admin edit tabs
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Block_Adminhtml_Sur_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('sur_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bs_sur')->__('Surveillance'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return BS_Sur_Block_Adminhtml_Sur_Edit_Tabs
     * @author Bui Phong
     */
    protected function _beforeToHtml()
    {


        $this->addTab(
            'form_sur',
            [
                'label' => Mage::helper('bs_sur')->__('Surveillance'),
                'title' => Mage::helper('bs_sur')->__('Surveillance'),
                'content' => $this->getLayout()->createBlock(
                    'bs_sur/adminhtml_sur_edit_tab_form'
                )
                    ->toHtml(),
            ]
        );

        $id = 0;
        if($this->getSur()->getId()){
            $id = $this->getSur()->getId();
        }
        $countRelations = $this->helper('bs_misc/relation')->countRelation($id, 'sur');

        $this->addTab(
            'ir',
            [
                'label' => Mage::helper('bs_sur')->__('IR (%s)', $countRelations['ir']),
                'url' => $this->getUrl('adminhtml/sur_sur/irs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'ncr',
            [
                'label' => Mage::helper('bs_sur')->__('NCR (%s)', $countRelations['ncr']),
                'url' => $this->getUrl('adminhtml/sur_sur/ncrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'drr',
            [
                'label' => Mage::helper('bs_sur')->__('DRR (%s)', $countRelations['drr']),
                'url' => $this->getUrl('adminhtml/sur_sur/drrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'qr',
            [
                'label' => Mage::helper('bs_sur')->__('QR (%s)', $countRelations['qr']),
                'url' => $this->getUrl('adminhtml/sur_sur/qrs', ['_current' => true]),
                'class' => 'ajax',
            ]
        );
        $this->addTab(
            'qn',
            [
                'label' => Mage::helper('bs_sur')->__('QN (%s)', $countRelations['qn']),
                'url' => $this->getUrl('adminhtml/sur_sur/qns', ['_current' => true]),
                'class' => 'ajax',
            ]
        );

        $this->addTab(
            'car',
            [
                'label' => Mage::helper('bs_sur')->__('CAR (%s)', $countRelations['car']),
                'url' => $this->getUrl('adminhtml/sur_sur/cars', ['_current' => true]),
                'class' => 'ajax',
            ]
        );
        /*if ($this->getSur()->getIr()) {


        }

        if ($this->getSur()->getNcr()) {


        }
        if ($this->getSur()->getQr()) {


        }

        if ($this->getSur()->getQn()) {


        }
        if ($this->getSur()->getDrr()) {


        }

        if ($this->getSur()->getCar()) {


        }*/
        return parent::_beforeToHtml();
    }



    /**
     * Retrieve surveillance entity
     *
     * @access public
     * @return BS_Sur_Model_Sur
     * @author Bui Phong
     */
    public function getSur()
    {
        return Mage::registry('current_sur');
    }
}
