<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine default helper
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Helper_Data extends Mage_Core_Helper_Abstract
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
