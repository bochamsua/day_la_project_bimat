<?php 
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature helper
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Helper_Signature extends Mage_Core_Helper_Abstract
{

    /**
     * get base files dir
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getFileBaseDir()
    {
        return Mage::getBaseDir('media').DS.'signature'.DS.'file';
    }

    /**
     * get base file url
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getFileBaseUrl()
    {
        return Mage::getBaseUrl('media').'signature'.'/'.'file';
    }
}
