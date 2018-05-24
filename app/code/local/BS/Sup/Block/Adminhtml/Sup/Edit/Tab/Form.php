<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier edit form tab
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Block_Adminhtml_Sup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Sup_Block_Adminhtml_Sup_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('sup_');
        $form->setFieldNameSuffix('sup');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'sup_form',
            ['legend' => Mage::helper('bs_sup')->__('Supplier')]
        );

        $currentObj = Mage::registry('current_sup');
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_sup/adminhtml_sup_helper_file')
        );

        $fieldset->addField(
            'sup_code',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('ID'),
                'name'  => 'sup_code',
            'required'  => true,
            'class' => 'required-entry',

           ]
        );

        $fieldset->addField(
            'sup_name',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('Supplier Name'),
                'name'  => 'sup_name',

           ]
        );

        $fieldset->addField(
            'sup_address',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('Supplier Address'),
                'name'  => 'sup_address',

            ]
        );

        $fieldset->addField(
            'cert_no',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('Cert No'),
                'name'  => 'cert_no',

           ]
        );

        $fieldset->addField(
            'sup_class',
            'select',
            [
                'label' => Mage::helper('bs_sup')->__('Class'),
                'name'  => 'sup_class',

            'values'=> Mage::getModel('bs_sup/sup_attribute_source_supclass')->getAllOptions(true),
           ]
        );

        $fieldset->addField(
            'rating',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('Rating'),
                'name'  => 'rating',

           ]
        );

        $fieldset->addField(
            'sup_source',
            'file',
            [
                'label' => Mage::helper('bs_sup')->__('Source'),
                'name'  => 'sup_source',

           ]
        );

        $fieldset->addField(
            'issue_date',
            'date',
            [
                'label' => Mage::helper('bs_sup')->__('Issue Date'),
                'name'  => 'issue_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'expire_date',
            'date',
            [
                'label' => Mage::helper('bs_sup')->__('Expire Date'),
                'name'  => 'expire_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'remaining',
            'text',
            [
                'label' => Mage::helper('bs_sup')->__('Remaining'),
                'name'  => 'remaining',

           ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_sup')->__('Remark'),
                'name'  => 'remark_text',

           ]
        );


        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_sup')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_sup')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_sup')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_sup')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getSupData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSupData());
            Mage::getSingleton('adminhtml/session')->setSupData(null);
        } elseif (Mage::registry('current_sup')) {
            $formValues = array_merge($formValues, Mage::registry('current_sup')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
