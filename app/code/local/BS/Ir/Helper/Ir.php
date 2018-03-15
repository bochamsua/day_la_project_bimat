<?php 
/**
 * BS_NCR extension
 * 
 * @category       BS
 * @package        BS_NCR
 * @copyright      Copyright (c) 2016
 */
/**
 * NCR helper
 *
 * @category    BS
 * @package     BS_NCR
 * @author Bui Phong
 */
class BS_Ir_Helper_Ir extends Mage_Core_Helper_Abstract
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
        return Mage::getBaseDir('media').DS.'ir'.DS.'file';
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
        return Mage::getBaseUrl('media').'ir'.'/'.'file';
    }
}
