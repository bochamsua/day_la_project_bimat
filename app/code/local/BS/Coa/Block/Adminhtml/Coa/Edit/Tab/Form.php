<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action edit form tab
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Block_Adminhtml_Coa_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Coa_Block_Adminhtml_Coa_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('coa_');
        $form->setFieldNameSuffix('coa');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'coa_form',
            ['legend' => Mage::helper('bs_coa')->__('Corrective Action')]
        );

        $currentObj = Mage::registry('current_coa');

        $refId = $this->getRequest()->getParam('ref_id');
        $refType = $this->getRequest()->getParam('ref_type');

        if($currentObj && $currentObj->getId()){
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
        }

        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_coa/adminhtml_coa_helper_file')
        );


        $fieldset->addField(
            'ref_id',
            'hidden',
            [
                'label' => Mage::helper('bs_coa')->__('ref_id'),
                'name'  => 'ref_id',


            ]
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            [
                'label' => Mage::helper('bs_coa')->__('ref_type'),
                'name'  => 'ref_type',


            ]
        );


        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_coa')->__('Description'),
                'name'  => 'description',

           ]
        );

        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionArray();
        $fieldset->addField(
            'dept_id',
            'select',
            [
                'label'     => Mage::helper('bs_coa')->__('Maint. Center'),
                'name'      => 'dept_id',
                'required'  => false,
                'values'    => $depts,
            ]
        );

        $fieldset->addField(
            'coa_source',
            'file',
            [
                'label' => Mage::helper('bs_coa')->__('Source'),
                'name'  => 'coa_source',

           ]
        );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_coa')->__('Issue Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'due_date',
            'date',
            [
                'label' => Mage::helper('bs_coa')->__('Expire Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'close_date',
            'date',
            [
                'label' => Mage::helper('bs_coa')->__('Close Date'),
                'name'  => 'close_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_coa')->__('Remark'),
                'name'  => 'remark_text',

           ]
        );


        /*$fieldset->addField(
            'coa_status',
            'select',
            [
                'label' => Mage::helper('bs_coa')->__('Status'),
                'name'  => 'coa_status',

            'values'=> Mage::getModel('bs_coa/coa_attribute_source_coastatus')->getAllOptions(true),
           ]
        );*/


        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_coa')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_coa')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_coa')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_coa')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getCoaData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCoaData());
            Mage::getSingleton('adminhtml/session')->setCoaData(null);
        } elseif (Mage::registry('current_coa')) {
            $formValues = array_merge($formValues, Mage::registry('current_coa')->getData());
        }

        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
