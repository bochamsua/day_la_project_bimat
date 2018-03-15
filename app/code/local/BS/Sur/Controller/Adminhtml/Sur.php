<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * module base admin controller
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Controller_Adminhtml_Sur extends Mage_Adminhtml_Controller_Action
{
    /**
     * upload file and get the uploaded name
     *
     * @access public
     * @param string $input
     * @param string $destinationFolder
     * @param array $data
     * @return string
     * @author Bui Phong
     */
    protected function _uploadAndGetName($input, $destinationFolder, $data)
    {
        try {
            if (isset($data[$input]['delete'])) {
                return '';
            } else {
                if($_FILES[$input]['size'] > 10485760){
                    $this->_getSession()->addError('Please upload smaller file, maximum file size allowed is 10MB');
                    return '';
                }else {
                    $uploader = new Varien_File_Uploader($input);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);
                    $result = $uploader->save($destinationFolder);

                    $imageFile = $result['path'].$result['file'];

                    Mage::helper('bs_misc/image')->resizeImage($imageFile);
                    return $result['file'];
                }

            }
        } catch (Exception $e) {
            if ($e->getCode() != Varien_File_Uploader::TMP_NAME_EMPTY) {
                throw $e;
            } else {
                if (isset($data[$input]['value'])) {
                    return $data[$input]['value'];
                }
            }
        }
        return '';
    }


}
