<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation edit form tab
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Qchaneff_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('qchaneff_');
        $form->setFieldNameSuffix('qchaneff');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'qchaneff_form',
            ['legend' => Mage::helper('bs_report')->__('QC HAN Evaluation')]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('Name'),
                'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

            ]
        );

        $fieldset->addField(
            'from_date',
            'date',
            [
                'label' => Mage::helper('bs_report')->__('From Date'),
                'name'  => 'from_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'to_date',
            'date',
            [
                'label' => Mage::helper('bs_report')->__('To Date'),
                'name'  => 'to_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'ins_id',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('Inspector Id'),
                'name'  => 'ins_id',

            ]
        );

        $fieldset->addField(
            'ir',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('Ir'),
                'name'  => 'ir',

            ]
        );

        $fieldset->addField(
            'ncr',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('NCR'),
                'name'  => 'ncr',

            ]
        );

        $fieldset->addField(
            'drr',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('DRR'),
                'name'  => 'drr',

            ]
        );

        $fieldset->addField(
            'qcwork',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('QC Work'),
                'name'  => 'qcwork',

            ]
        );

        $fieldset->addField(
            'd1',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('D1'),
                'name'  => 'd1',

            ]
        );

        $fieldset->addField(
            'd2',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('D2'),
                'name'  => 'd2',

            ]
        );

        $fieldset->addField(
            'd3',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('D3'),
                'name'  => 'd3',

            ]
        );

        $fieldset->addField(
            'dall',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('D'),
                'name'  => 'dall',

            ]
        );

        $fieldset->addField(
            'level',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('Level'),
                'name'  => 'level',

            ]
        );

        $fieldset->addField(
            'note',
            'textarea',
            [
                'label' => Mage::helper('bs_report')->__('Note'),
                'name'  => 'note',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_report')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_report')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_report')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_qchaneff')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getQchaneffData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getQchaneffData());
            Mage::getSingleton('adminhtml/session')->setQchaneffData(null);
        } elseif (Mage::registry('current_qchaneff')) {
            $formValues = array_merge($formValues, Mage::registry('current_qchaneff')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
