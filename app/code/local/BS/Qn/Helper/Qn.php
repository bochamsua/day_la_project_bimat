<?php 
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN helper
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Helper_Qn extends Mage_Core_Helper_Abstract
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
        return Mage::getBaseDir('media').DS.'qn'.DS.'file';
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
        return Mage::getBaseUrl('media').'qn'.'/'.'file';
    }
}
