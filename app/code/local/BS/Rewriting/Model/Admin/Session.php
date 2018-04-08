<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Model_Admin_Session extends Mage_Admin_Model_Session {
	public function login($username, $password, $request = null, $bypass = false)
	{
		if (empty($username) || empty($password)) {
			return;
		}

		try {
			/** @var $user Mage_Admin_Model_User */
			$user = $this->_factory->getModel('admin/user');
			$user->login($username, $password, $bypass);
			if ($user->getId()) {
				$this->renewSession();

				if (Mage::getSingleton('adminhtml/url')->useSecretKey()) {
					Mage::getSingleton('adminhtml/url')->renewSecretUrls();
				}
				$this->setIsFirstPageAfterLogin(true);
				$this->setUser($user);
				$this->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());

				$alternativeUrl = $this->_getRequestUri($request);
				$redirectUrl = $this->_urlPolicy->getRedirectUrl($user, $request, $alternativeUrl);
				if ($redirectUrl) {
					Mage::dispatchEvent('admin_session_user_login_success', ['user' => $user]);
					$this->_response->clearHeaders()
					                ->setRedirect($redirectUrl)
					                ->sendHeadersAndExit();
				}
			} else {
				Mage::throwException(Mage::helper('adminhtml')->__('Invalid User Name or Password.'));
			}
		} catch (Mage_Core_Exception $e) {
			Mage::dispatchEvent('admin_session_user_login_failed',
				['user_name' => $username, 'exception' => $e]);
			if ($request && !$request->getParam('messageSent')) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$request->setParam('messageSent', true);
			}
		}

		return $user;
	}
}