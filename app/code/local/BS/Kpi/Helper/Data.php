<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * Kpi default helper
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Helper_Data extends Mage_Core_Helper_Abstract
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
