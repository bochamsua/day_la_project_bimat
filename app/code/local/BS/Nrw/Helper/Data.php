<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Nrw default helper
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Helper_Data extends Mage_Core_Helper_Abstract
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
        $converted = [];
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
}
