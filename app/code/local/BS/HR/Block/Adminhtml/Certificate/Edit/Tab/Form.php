<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate edit form tab
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Certificate_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('certificate_');
        $form->setFieldNameSuffix('certificate');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'certificate_form',
            ['legend' => Mage::helper('bs_hr')->__('Certificate')]
        );

        $fieldset->addField(
            'cert_desc',
            'text',
            [
                'label' => Mage::helper('bs_hr')->__('Description'),
                'name'  => 'cert_desc',

            ]
        );

        $currentCert = Mage::registry('current_certificate');
        $inspectorId = null;
        if($this->getRequest()->getParam('ins_id')){
            $inspectorId = $this->getRequest()->getParam('ins_id');
        }elseif ($currentCert){
            $inspectorId = $currentCert->getInsId();
        }

        /*$ins = Mage::getResourceModel('admin/user_collection')->addFieldToFilter('user_id', array('gt' => 1));
        $insArray = array();
        foreach ($ins as $in) {
            $insArray[] = array(
                'value' => $in->getId(),
                'label' => $in->getFirstname().' '. $in->getLastname()
            );
        }
        $fieldset->addField(
            'ins_id',
            'select',
            array(
                'label'     => Mage::helper('bs_hr')->__('Inspector'),
                'name'      => 'ins_id',
                'required'  => false,
                'values'    => $insArray,
                //'after_element_html' => $html
            )
        );*/



        $fieldset->addField(
            'crs_approved',
            'date',
            [
                'label' => Mage::helper('bs_hr')->__('CRS Approved Date'),
                'name'  => 'crs_approved',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'crs_expire',
            'date',
            [
                'label' => Mage::helper('bs_hr')->__('CRS Expire Date'),
                'name'  => 'crs_expire',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'caav_approved',
            'date',
            [
                'label' => Mage::helper('bs_hr')->__('CAAV Approved Date'),
                'name'  => 'caav_approved',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'caav_expire',
            'date',
            [
                'label' => Mage::helper('bs_hr')->__('CAAV Expire Date'),
                'name'  => 'caav_expire',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            ]
        );

        $fieldset->addField(
            'ac_id',
            'text',
            [
                'label' => Mage::helper('bs_hr')->__('Aircraft'),
                'name'  => 'ac_id',

            ]
        );

        $fieldset->addField(
            'certtype_id',
            'text',
            [
                'label' => Mage::helper('bs_hr')->__('Cert Type'),
                'name'  => 'certtype_id',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_hr')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_hr')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_hr')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_certificate')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getCertificateData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCertificateData());
            Mage::getSingleton('adminhtml/session')->setCertificateData(null);
        } elseif (Mage::registry('current_certificate')) {
            $formValues = array_merge($formValues, Mage::registry('current_certificate')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
