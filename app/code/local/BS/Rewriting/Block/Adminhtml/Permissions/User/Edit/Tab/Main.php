<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Permissions_User_Edit_Tab_Main extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main {
	protected function _prepareForm()
	{
		$model = Mage::registry('permissions_user');

		$form = new Varien_Data_Form();

		$form->setHtmlIdPrefix('user_');

		$fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Account Information')));

		if ($model->getUserId()) {
			$fieldset->addField('user_id', 'hidden', array(
				'name' => 'user_id',
			));
		} else {
			if (! $model->hasData('is_active')) {
				$model->setIsActive(1);
			}
		}

		$fieldset->addField('username', 'text', array(
			'name'  => 'username',
			'label' => Mage::helper('adminhtml')->__('User Name'),
			'id'    => 'username',
			'title' => Mage::helper('adminhtml')->__('User Name'),
			'required' => true,
		));

		$fieldset->addField('firstname', 'text', array(
			'name'  => 'firstname',
			'label' => Mage::helper('adminhtml')->__('First Name'),
			'id'    => 'firstname',
			'title' => Mage::helper('adminhtml')->__('First Name'),
			'required' => true,
		));

		$fieldset->addField('lastname', 'text', array(
			'name'  => 'lastname',
			'label' => Mage::helper('adminhtml')->__('Last Name'),
			'id'    => 'lastname',
			'title' => Mage::helper('adminhtml')->__('Last Name'),
			'required' => true,
		));

		$fieldset->addField('email', 'text', array(
			'name'  => 'email',
			'label' => Mage::helper('adminhtml')->__('Email'),
			'id'    => 'customer_email',
			'title' => Mage::helper('adminhtml')->__('User Email'),
			'class' => 'required-entry validate-email',
			'required' => true,
		));

		$misc = $this->helper('bs_misc');
		$regions = Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false);
		if($misc->isQCAdmin() || $misc->isQAAdmin()){
            $regions = Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false, false, true);
        }
        $fieldset->addField(
            'region',
            'select',
            array(
                'label' => Mage::helper('bs_sur')->__('Region'),
                'name'  => 'region',
                'required'  => true,
                'class' => 'required-entry',

                'values'=> $regions,
            )
        );


        $sections = Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false);
        if($misc->isQCAdmin() || $misc->isQAAdmin()){
            $sections = Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false,false, true);
        }
        $fieldset->addField(
            'section',
            'select',
            array(
                'label' => Mage::helper('bs_sur')->__('Section'),
                'name'  => 'section',

                'values'=> $sections,
            )
        );


		$fieldset->addField('vaeco_id', 'text', array(
			'name'  => 'vaeco_id',
			'label' => Mage::helper('adminhtml')->__('Vaeco ID'),
			'id'    => 'vaeco_id',
			'title' => Mage::helper('adminhtml')->__('Vaeco ID'),
		));

		$fieldset->addField('crs_no', 'text', array(
			'name'  => 'crs_no',
			'label' => Mage::helper('adminhtml')->__('CRS Number'),
			'id'    => 'crs_no',
			'title' => Mage::helper('adminhtml')->__('CRS Number'),
		));


		if ($model->getUserId()) {
			$fieldset->addField('password', 'password', array(
				'name'  => 'new_password',
				'label' => Mage::helper('adminhtml')->__('New Password'),
				'id'    => 'new_pass',
				'title' => Mage::helper('adminhtml')->__('New Password'),
				'class' => 'input-text validate-password',
			));

			$fieldset->addField('confirmation', 'password', array(
				'name'  => 'password_confirmation',
				'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
				'id'    => 'confirmation',
				'class' => 'input-text validate-cpassword',
			));
		}
		else {
			$fieldset->addField('password', 'password', array(
				'name'  => 'password',
				'label' => Mage::helper('adminhtml')->__('Password'),
				'id'    => 'customer_pass',
				'title' => Mage::helper('adminhtml')->__('Password'),
				'class' => 'input-text required-entry validate-password',
				'required' => true,
			));
			$fieldset->addField('confirmation', 'password', array(
				'name'  => 'password_confirmation',
				'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
				'id'    => 'confirmation',
				'title' => Mage::helper('adminhtml')->__('Password Confirmation'),
				'class' => 'input-text required-entry validate-cpassword',
				'required' => true,
			));
		}

		if (Mage::getSingleton('admin/session')->getUser()->getId() != $model->getUserId()) {
			$fieldset->addField('is_active', 'select', array(
				'name'      => 'is_active',
				'label'     => Mage::helper('adminhtml')->__('This account is'),
				'id'        => 'is_active',
				'title'     => Mage::helper('adminhtml')->__('Account Status'),
				'class'     => 'input-select',
				'style'        => 'width: 80px',
				'options'    => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
			));
		}

		$fieldset->addField('user_roles', 'hidden', array(
			'name' => 'user_roles',
			'id'   => '_user_roles',
		));

		$data = $model->getData();

		unset($data['password']);

		$form->setValues($data);

		$this->setForm($form);

		return $this;
	}
}