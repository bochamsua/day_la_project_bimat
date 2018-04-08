<?php
/**
 * BS_Nonroutine extension
 * 
 * @category       BS
 * @package        BS_Nonroutine
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Work Non-Routine edit form tab
 *
 * @category    BS
 * @package     BS_Nonroutine
 * @author Bui Phong
 */
class BS_Nonroutine_Block_Adminhtml_Nonroutine_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Nonroutine_Block_Adminhtml_Nonroutine_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('nonroutine_');
        $form->setFieldNameSuffix('nonroutine');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'nonroutine_form',
            ['legend' => Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine')]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => Mage::helper('bs_nonroutine')->__('Name'),
                'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_nonroutine')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_nonroutine')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_nonroutine')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_nonroutine')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getNonroutineData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNonroutineData());
            Mage::getSingleton('adminhtml/session')->setNonroutineData(null);
        } elseif (Mage::registry('current_nonroutine')) {
            $formValues = array_merge($formValues, Mage::registry('current_nonroutine')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
