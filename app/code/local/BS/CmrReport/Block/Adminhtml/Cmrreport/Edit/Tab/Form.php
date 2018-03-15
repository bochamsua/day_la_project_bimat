<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report edit form tab
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Block_Adminhtml_Cmrreport_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('cmrreport_');
        $form->setFieldNameSuffix('cmrreport');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'cmrreport_form',
            array('legend' => Mage::helper('bs_cmrreport')->__('CMR Report'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('bs_cmrreport')->__('Name'),
                'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_cmrreport')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_cmrreport')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_cmrreport')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_cmrreport')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCmrreportData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCmrreportData());
            Mage::getSingleton('adminhtml/session')->setCmrreportData(null);
        } elseif (Mage::registry('current_cmrreport')) {
            $formValues = array_merge($formValues, Mage::registry('current_cmrreport')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
