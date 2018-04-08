<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_System_Account_Edit_Form extends Mage_Adminhtml_Block_System_Account_Edit_Form {
	protected function _prepareForm()
	{
		$userId = Mage::getSingleton('admin/session')->getUser()->getId();
		$user = Mage::getModel('admin/user')
		            ->load($userId);
		$user->unsetData('password');

		$form = new Varien_Data_Form();

		$fieldset = $form->addFieldset('base_fieldset', ['legend'=>Mage::helper('adminhtml')->__('Account Information')]);

		$fieldset->addField('username', 'text', [
				'name'  => 'username',
				'label' => Mage::helper('adminhtml')->__('User Name'),
				'title' => Mage::helper('adminhtml')->__('User Name'),
				'required' => true,
				'readonly'  => true
            ]
		);

		$fieldset->addField('firstname', 'text', [
				'name'  => 'firstname',
				'label' => Mage::helper('adminhtml')->__('First Name'),
				'title' => Mage::helper('adminhtml')->__('First Name'),
				'required' => true,
            ]
		);

		$fieldset->addField('lastname', 'text', [
				'name'  => 'lastname',
				'label' => Mage::helper('adminhtml')->__('Last Name'),
				'title' => Mage::helper('adminhtml')->__('Last Name'),
				'required' => true,
            ]
		);



		$fieldset->addField('user_id', 'hidden', [
				'name'  => 'user_id',
            ]
		);

		$fieldset->addField('email', 'text', [
				'name'  => 'email',
				'label' => Mage::helper('adminhtml')->__('Email'),
				'title' => Mage::helper('adminhtml')->__('User Email'),
				'required' => true,
            ]
		);


		$fieldset->addField('vaeco_id', 'text', [
			'name'  => 'vaeco_id',
			'label' => Mage::helper('adminhtml')->__('Vaeco ID'),
			'id'    => 'vaeco_id',
			'title' => Mage::helper('adminhtml')->__('Vaeco ID'),
        ]);

		$fieldset->addField('crs_no', 'text', [
			'name'  => 'crs_no',
			'label' => Mage::helper('adminhtml')->__('CRS Number'),
			'id'    => 'crs_no',
			'title' => Mage::helper('adminhtml')->__('CRS Number'),
        ]);


		$fieldset->addField('password', 'password', [
				'name'  => 'new_password',
				'label' => Mage::helper('adminhtml')->__('New Password'),
				'title' => Mage::helper('adminhtml')->__('New Password'),
				'class' => 'input-text validate-password',
            ]
		);

		$fieldset->addField('confirmation', 'password', [
				'name'  => 'password_confirmation',
				'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
				'class' => 'input-text validate-cpassword',
            ]
		);

		$form->setValues($user->getData());
		$form->setAction($this->getUrl('*/system_account/save'));
		$form->setMethod('post');
		$form->setUseContainer(true);
		$form->setId('edit_form');

		$this->setForm($form);

		return $this;
	}
}