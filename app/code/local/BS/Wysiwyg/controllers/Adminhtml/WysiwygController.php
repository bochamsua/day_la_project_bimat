<?php
/**
 * BS_Wysiwyg extension
 * 
 * @category       BS
 * @package        BS_Wysiwyg
 * @copyright      Copyright (c) 2017
 */
/**
 * Wysiwyg admin controller
 *
 * @category    BS
 * @package     BS_Wysiwyg
 * @author Bui Phong
 */
class BS_Wysiwyg_Adminhtml_WysiwygController extends Mage_Adminhtml_Controller_Action
{
	public function loadAction()
	{
		$request = new Varien_Object($this->getRequest()->getParams());
		if ($request) {

			$uploader = new Mage_Core_Model_File_Uploader('file');
			$allowed = Mage::getSingleton('cms/wysiwyg_images_storage')->getAllowedExtensions('image');
			$uploader->setAllowedExtensions($allowed);

			$uploader->setAllowRenameFiles(true);
			$uploader->setFilesDispersion(true);

			$result = $uploader->save(Mage::helper('cms/wysiwyg_images')->getCurrentPath());

			$imageFile = Mage::getBaseDir('media').'/'.Mage_Cms_Model_Wysiwyg_Config::IMAGE_DIRECTORY.'/'.$result['file'];

			Mage::helper('bs_misc/image')->resizeImage($imageFile, 568, 868);

			$imageUrl = sprintf('%s%s/%s', Mage::getBaseUrl('media'), Mage_Cms_Model_Wysiwyg_Config::IMAGE_DIRECTORY, $result['file']);

			$array = array(
				'url' => $imageUrl,
				'title' => $_FILES['file']['name']
			);

			echo stripslashes(json_encode($array));
			exit;
		}
	}

	protected function _isAllowed()
	{
		return true;
	}
}
