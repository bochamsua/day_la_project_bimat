<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule edit form tab
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Block_Adminhtml_Schedule_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Schedule_Block_Adminhtml_Schedule_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('schedule_');
        $form->setFieldNameSuffix('schedule');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'schedule_form',
            ['legend' => Mage::helper('bs_schedule')->__('Schedule')]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => Mage::helper('bs_schedule')->__('Name'),
                'name'  => 'name',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_schedule')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_schedule')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_schedule')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_schedule')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getScheduleData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getScheduleData());
            Mage::getSingleton('adminhtml/session')->setScheduleData(null);
        } elseif (Mage::registry('current_schedule')) {
            $formValues = array_merge($formValues, Mage::registry('current_schedule')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
