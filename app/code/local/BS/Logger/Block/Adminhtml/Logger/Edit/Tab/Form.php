<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger edit form tab
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Block_Adminhtml_Logger_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Logger_Block_Adminhtml_Logger_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('logger_');
        $form->setFieldNameSuffix('logger');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'logger_form',
            ['legend' => Mage::helper('bs_logger')->__('Logger')]
        );

        $fieldset->addType('username','BS_Logger_Model_Form_Element_Username');
        $fieldset->addType('serial','BS_Logger_Model_Form_Element_Serial');

        $fieldset->addField('user_id', 'username', [
            'label'     => Mage::helper('bs_logger')->__('User:'),
            'name'      => 'title',
        ]);

        $fieldset->addField(
            'ip',
            'label',
            [
                'label' => Mage::helper('bs_logger')->__('IP Address'),
                'name'  => 'ip',

            ]
        );

       $fieldset->addField('created_at', 'label', [
            'label'     => Mage::helper('bs_logger')->__('Date:'),
            'name'      => 'title',
       ]);



        $fieldset->addField(
            'message',
            'label',
            [
                'label' => Mage::helper('bs_logger')->__('Message'),
                'name'  => 'title',

            ]
        );

        $fieldset->addField('content', 'serial', [
            'label'     => Mage::helper('bs_logger')->__('Data:'),
            'name'      => 'title',
        ]);
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_logger')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_logger')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_logger')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_logger')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getLoggerData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getLoggerData());
            Mage::getSingleton('adminhtml/session')->setLoggerData(null);
        } elseif (Mage::registry('current_logger')) {
            $formValues = array_merge($formValues, Mage::registry('current_logger')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
