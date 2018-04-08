<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin source model for Filter
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Model_Mor_Attribute_Source_Morfilter
{
    /**
     * get possible values
     *
     * @access public
     * @param bool $withEmpty
     * @param bool $defaultValues
     * @return array
     * @author Bui Phong
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $options =  [
            [
                'label' => Mage::helper('bs_mor')->__('Equipment reliability'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Lightning strike '),
                'value' => 2
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Bird strike'),
                'value' => 3
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Objective'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Human error'),
                'value' => 5
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Hard landing'),
                'value' => 6
            ],
            [
                'label' => Mage::helper('bs_mor')->__('Other'),
                'value' => 7
            ],
        ];
        if ($withEmpty) {
            array_unshift($options, ['label'=>'', 'value'=>'']);
        }
        return $options;

    }

    /**
     * get options as array
     *
     * @access public
     * @param bool $withEmpty
     * @return string
     * @author Bui Phong
     */
    public function getOptionsArray($withEmpty = true)
    {
        $options = [];
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    /**
     * get option text
     *
     * @access public
     * @param mixed $value
     * @return string
     * @author Bui Phong
     */
    public function getOptionText($value)
    {
        $options = $this->getOptionsArray();
        if (!is_array($value)) {
            $value = explode(',', $value);
        }
        $texts = [];
        foreach ($value as $v) {
            if (isset($options[$v])) {
                $texts[] = $options[$v];
            }
        }
        return implode(', ', $texts);
    }
}
