<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Work Day edit form tab
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Workday_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Workday_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('workday_');
        $form->setFieldNameSuffix('workday');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'workday_form',
            ['legend' => Mage::helper('bs_report')->__('Work Day')]
        );

        $fieldset->addField(
            'month',
            'select',
            [
                'label' => Mage::helper('bs_report')->__('Month'),
                'name'  => 'month',

            'values'=> Mage::getModel('bs_report/workday_attribute_source_month')->getAllOptions(true),
            ]
        );

        $fieldset->addField(
            'year',
            'select',
            [
                'label' => Mage::helper('bs_report')->__('Year'),
                'name'  => 'year',

            'values'=> Mage::getModel('bs_report/workday_attribute_source_year')->getAllOptions(true),
            ]
        );

        $fieldset->addField(
            'days',
            'text',
            [
                'label' => Mage::helper('bs_report')->__('Days'),
                'name'  => 'days',

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
        $formValues = Mage::registry('current_workday')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getWorkdayData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getWorkdayData());
            Mage::getSingleton('adminhtml/session')->setWorkdayData(null);
        } elseif (Mage::registry('current_workday')) {
            $formValues = array_merge($formValues, Mage::registry('current_workday')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
