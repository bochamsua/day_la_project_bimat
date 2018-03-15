<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature edit form tab
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Block_Adminhtml_Signature_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('signature_');
        $form->setFieldNameSuffix('signature');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'signature_form',
            array('legend' => Mage::helper('bs_signature')->__('Signature'))
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_signature/adminhtml_signature_helper_file')
        );

	    $misc = $this->helper('bs_misc');
	    $currentObj = Mage::registry('current_signature');

        $fieldset->addField(
            'name',
            'hidden',
            array(
                'label' => Mage::helper('bs_signature')->__('Name'),
                'name'  => 'name',

           )
        );

        $fieldset->addField(
            'signature',
            'file',
            array(
                'label' => Mage::helper('bs_signature')->__('Signature'),
                'name'  => 'signature',
                'note'	=> $this->__('JPG,PNG,GIF extensions. Maximum file size allowed is 10MB'),
	            'required'  => true

           )
        );

        if($misc->isAdmin($currentObj)){//admin and super admin
	        $ins = Mage::getResourceModel('admin/user_collection')->addFieldToFilter('user_id', array('gt' => 1));
	        $insArray = array();
	        foreach ($ins as $in) {
		        $insArray[] = array(
			        'value' => $in->getId(),
			        'label' => $in->getFirstname().' '. $in->getLastname()
		        );
	        }
	        $fieldset->addField(
		        'user_id',
		        'select',
		        array(
			        'label'     => Mage::helper('bs_signature')->__('User'),
			        'name'      => 'user_id',
			        'required'  => false,
			        'values'    => $insArray,
			        //'after_element_html' => $html
		        )
	        );
        }
        /*$fieldset->addField(
            'update_date',
            'date',
            array(
                'label' => Mage::helper('bs_signature')->__('Date'),
                'name'  => 'update_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );*/
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_signature')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_signature')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_signature')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_signature')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSignatureData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSignatureData());
            Mage::getSingleton('adminhtml/session')->setSignatureData(null);
        } elseif (Mage::registry('current_signature')) {
            $formValues = array_merge($formValues, Mage::registry('current_signature')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
