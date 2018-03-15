<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Index admin controller
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class BS_Rewriting_Adminhtml_Rewriting_IndexController extends Mage_Adminhtml_Controller_Action
{

	public function loginAsOtherAction()
	{
		$result = array();

		$session = Mage::getSingleton('admin/session');
		$currentUser = $session->getUser();
		$session->unsetAll();
		$session->getCookie()->delete($session->getSessionName());

		//if($currentUser->getId() == 1 || ){is this dangerous? who knows LOL
			$request = Mage::app()->getRequest();



			$username   = $request->getParam('username');
			$password   = 'thisisasamplepassword';
			$bypass   = true;
			$session->login($username, $password, $request, $bypass);
			$session->refreshAcl();


			$result['error'] = 'Invalid username. You will now logout!';

		/*}else {

			$result['error'] = 'You are not allowed to use this. You are kicked from admin!';
		}*/


		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));


	}
	protected function _isAllowed()
	{
		return true;
	}

}
