<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code edit form tab
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncausegroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('ncausegroup_');
        $form->setFieldNameSuffix('ncausegroup');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'ncausegroup_form',
            ['legend' => Mage::helper('bs_ncause')->__('Root Cause Code')]
        );

        $fieldset->addField(
            'group_code',
            'text',
            [
                'label' => Mage::helper('bs_ncause')->__('Group Code'),
                'name'  => 'group_code',

            ]
        );

        $fieldset->addField(
            'group_name',
            'text',
            [
                'label' => Mage::helper('bs_ncause')->__('Name'),
                'name'  => 'group_name',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_ncause')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_ncause')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_ncause')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_ncausegroup')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getNcausegroupData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNcausegroupData());
            Mage::getSingleton('adminhtml/session')->setNcausegroupData(null);
        } elseif (Mage::registry('current_ncausegroup')) {
            $formValues = array_merge($formValues, Mage::registry('current_ncausegroup')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
