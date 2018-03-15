<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Setting edit form tab
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Setting_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Setting_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('setting_');
        $form->setFieldNameSuffix('setting');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'setting_form',
            array('legend' => Mage::helper('bs_report')->__('Setting'))
        );

        $fieldset->addField(
            'code',
            'text',
            array(
                'label' => Mage::helper('bs_report')->__('Code'),
                'name'  => 'code',

           )
        );

        $fieldset->addField(
            'value',
            'text',
            array(
                'label' => Mage::helper('bs_report')->__('Value'),
                'name'  => 'value',

           )
        );

        $fieldset->addField(
            'note',
            'textarea',
            array(
                'label' => Mage::helper('bs_report')->__('Note'),
                'name'  => 'note',

           )
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
        $formValues = Mage::registry('current_setting')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSettingData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSettingData());
            Mage::getSingleton('adminhtml/session')->setSettingData(null);
        } elseif (Mage::registry('current_setting')) {
            $formValues = array_merge($formValues, Mage::registry('current_setting')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
