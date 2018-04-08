<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Model_Admin_User extends Mage_Admin_Model_User {
	public function authenticate($username, $password, $bypass = false)
	{
		$config = Mage::getStoreConfigFlag('admin/security/use_case_sensitive_login');
		$result = false;

		try {
			Mage::dispatchEvent('admin_user_authenticate_before', [
				'username' => $username,
				'user'     => $this
            ]);
			$this->loadByUsername($username);
			$sensitive = ($config) ? $username == $this->getUsername() : true;

			if ($sensitive && $this->getId() && Mage::helper('core')->validateHash($password, $this->getPassword()) || $bypass) {
				if ($this->getIsActive() != '1') {
					Mage::throwException(Mage::helper('adminhtml')->__('This account is inactive.'));
				}
				if (!$this->hasAssigned2Role($this->getId())) {
					Mage::throwException(Mage::helper('adminhtml')->__('Access denied.'));
				}
				$result = true;
			}

			Mage::dispatchEvent('admin_user_authenticate_after', [
				'username' => $username,
				'password' => $password,
				'user'     => $this,
				'result'   => $result,
            ]);
		}
		catch (Mage_Core_Exception $e) {
			$this->unsetData();
			throw $e;
		}

		if (!$result) {
			$this->unsetData();
		}
		return $result;
	}

	/**
	 * Login user
	 *
	 * @param   string $login
	 * @param   string $password
	 * @return  Mage_Admin_Model_User
	 */
	public function login($username, $password, $bypass = false)
	{
		if ($this->authenticate($username, $password, $bypass)) {
			$this->getResource()->recordLogin($this);
		}
		return $this;
	}

	public function validateCurrentPassword($password)
	{
		return true;
	}

	public function validate()
	{
		$errors = new ArrayObject();

		if (!Zend_Validate::is($this->getUsername(), 'NotEmpty')) {
			$errors[] = Mage::helper('adminhtml')->__('User Name is required field.');
		}

		if (!Zend_Validate::is($this->getFirstname(), 'NotEmpty')) {
			$errors[] = Mage::helper('adminhtml')->__('First Name is required field.');
		}

		if (!Zend_Validate::is($this->getLastname(), 'NotEmpty')) {
			$errors[] = Mage::helper('adminhtml')->__('Last Name is required field.');
		}

		if (!Zend_Validate::is($this->getEmail(), 'EmailAddress')) {
			$errors[] = Mage::helper('adminhtml')->__('Please enter a valid email.');
		}

		if ($this->hasNewPassword()) {
			/*if (Mage::helper('core/string')->strlen($this->getNewPassword()) < self::MIN_PASSWORD_LENGTH) {
				$errors[] = Mage::helper('adminhtml')->__('Password must be at least of %d characters.', self::MIN_PASSWORD_LENGTH);
			}

			if (!preg_match('/[a-z]/iu', $this->getNewPassword())
			    || !preg_match('/[0-9]/u', $this->getNewPassword())
			) {
				$errors[] = Mage::helper('adminhtml')->__('Password must include both numeric and alphabetic characters.');
			}*/

			if ($this->hasPasswordConfirmation() && $this->getNewPassword() != $this->getPasswordConfirmation()) {
				$errors[] = Mage::helper('adminhtml')->__('Password confirmation must be same as password.');
			}

			Mage::dispatchEvent('admin_user_validate', [
				'user' => $this,
				'errors' => $errors,
            ]);
		}

		if ($this->userExists()) {
			$errors[] = Mage::helper('adminhtml')->__('A user with the same user name or email aleady exists.');
		}

		if (count($errors) === 0) {
			return true;
		}
		return (array)$errors;
	}

}