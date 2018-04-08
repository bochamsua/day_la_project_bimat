<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Survey Group edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Taskgroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('taskgroup_');
        $form->setFieldNameSuffix('taskgroup');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'taskgroup_form',
            ['legend' => Mage::helper('bs_misc')->__('Survey Group')]
        );

        $fieldset->addField(
            'group_name',
            'text',
            [
                'label' => Mage::helper('bs_misc')->__('Group Name'),
                'name'  => 'group_name',
            'required'  => true,
            'class' => 'required-entry',

            ]
        );

        $fieldset->addField(
            'group_code',
            'text',
            [
                'label' => Mage::helper('bs_misc')->__('Group Code'),
                'name'  => 'group_code',

            ]
        );

        $formValues = Mage::registry('current_taskgroup')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getTaskgroupData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getTaskgroupData());
            Mage::getSingleton('adminhtml/session')->setTaskgroupData(null);
        } elseif (Mage::registry('current_taskgroup')) {
            $formValues = array_merge($formValues, Mage::registry('current_taskgroup')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
