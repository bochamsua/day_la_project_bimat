<?php
/**
 * BS_Wysiwyg extension
 * 
 * @category       BS
 * @package        BS_Wysiwyg
 * @copyright      Copyright (c) 2017
 */
/**
 * Wysiwyg default helper
 *
 * @category    BS
 * @package     BS_Wysiwyg
 * @author Bui Phong
 */
class BS_Wysiwyg_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Bui Phong
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
}
