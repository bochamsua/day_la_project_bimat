<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report edit form tab
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Block_Adminhtml_Routine_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Routine_Block_Adminhtml_Routine_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('routine_');
        $form->setFieldNameSuffix('routine');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'routine_form',
            array('legend' => Mage::helper('bs_routine')->__('Routine Report'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('bs_routine')->__('Name'),
                'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_routine')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_routine')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_routine')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_routine')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getRoutineData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getRoutineData());
            Mage::getSingleton('adminhtml/session')->setRoutineData(null);
        } elseif (Mage::registry('current_routine')) {
            $formValues = array_merge($formValues, Mage::registry('current_routine')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
