<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2017
 */
/**
 * Staff edit form tab
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Staff_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Staff_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('staff_');
        $form->setFieldNameSuffix('staff');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'staff_form',
            ['legend' => Mage::helper('bs_hr')->__('Staff')]
        );

	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
	    $inspectors = [];
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = $in->getFirstname().' '.$in->getLastname();
	    }

        $fieldset->addField(
            'user_id',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Admin User'),
                'name'  => 'user_id',
	            'values'    => $inspectors

            ]
        );

        $fieldset->addField(
            'room',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Room'),
                'name'  => 'room',

            'values'=> Mage::getModel('bs_hr/staff_attribute_source_room')->getAllOptions(true),
            ]
        );

        $fieldset->addField(
            'region',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Region'),
                'name'  => 'region',

            'values'=> Mage::getModel('bs_hr/staff_attribute_source_region')->getAllOptions(true),
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
        $formValues = Mage::registry('current_staff')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getStaffData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getStaffData());
            Mage::getSingleton('adminhtml/session')->setStaffData(null);
        } elseif (Mage::registry('current_staff')) {
            $formValues = array_merge($formValues, Mage::registry('current_staff')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
