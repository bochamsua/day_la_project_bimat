<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority edit form tab
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Block_Adminhtml_Aut_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Aut_Block_Adminhtml_Aut_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('aut_');
        $form->setFieldNameSuffix('aut');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'aut_form',
            ['legend' => Mage::helper('bs_aut')->__('Authority')]
        );

        $currentObj = Mage::registry('current_aut');
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_aut/adminhtml_aut_helper_file')
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Authority'),
                'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

           ]
        );

        $fieldset->addField(
            'aut_id',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('ID'),
                'name'  => 'aut_id',
            'required'  => true,
            'class' => 'required-entry',

           ]
        );

        $fieldset->addField(
            'approved_scope',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Approved Scope'),
                'name'  => 'approved_scope',

           ]
        );

        $fieldset->addField(
            'station',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Station'),
                'name'  => 'station',

           ]
        );

        $fieldset->addField(
            'approval_no',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Approval Number'),
                'name'  => 'approval_no',

           ]
        );

        $fieldset->addField(
            'aut_source',
            'file',
            [
                'label' => Mage::helper('bs_aut')->__('Source'),
                'name'  => 'aut_source',

           ]
        );

        $fieldset->addField(
            'issue_date',
            'date',
            [
                'label' => Mage::helper('bs_aut')->__('Issue Date'),
                'name'  => 'issue_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'expire_date',
            'date',
            [
                'label' => Mage::helper('bs_aut')->__('Expire Date'),
                'name'  => 'expire_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'remaining',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Remaining'),
                'name'  => 'remaining',

           ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_aut')->__('Remark'),
                'name'  => 'remark_text',

           ]
        );

        $fieldset->addField(
            'ins_id',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Inspector'),
                'name'  => 'ins_id',

           ]
        );

        $fieldset->addField(
            'aut_status',
            'select',
            [
                'label' => Mage::helper('bs_aut')->__('Status'),
                'name'  => 'aut_status',

            'values'=> Mage::getModel('bs_aut/aut_attribute_source_autstatus')->getAllOptions(true),
           ]
        );

        $fieldset->addField(
            'section',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Section'),
                'name'  => 'section',

           ]
        );

        $fieldset->addField(
            'region',
            'text',
            [
                'label' => Mage::helper('bs_aut')->__('Region'),
                'name'  => 'region',

           ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_aut')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_aut')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_aut')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_aut')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getAutData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getAutData());
            Mage::getSingleton('adminhtml/session')->setAutData(null);
        } elseif (Mage::registry('current_aut')) {
            $formValues = array_merge($formValues, Mage::registry('current_aut')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
