<?php 
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA helper
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Helper_Hira extends Mage_Core_Helper_Abstract
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
        return Mage::getBaseDir('media').DS.'hira'.DS.'file';
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
        return Mage::getBaseUrl('media').'hira'.'/'.'file';
    }
}
