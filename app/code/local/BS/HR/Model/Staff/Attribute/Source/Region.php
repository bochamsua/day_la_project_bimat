<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2017
 */
/**
 * Admin source model for Region
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Model_Staff_Attribute_Source_Region
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
                'label' => Mage::helper('bs_hr')->__('Hanoi'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_hr')->__('Ho Chi Minh'),
                'value' => 2
            ],
            [
                'label' => Mage::helper('bs_hr')->__('Da Nang'),
                'value' => 3
            ],
            [
                'label' => Mage::helper('bs_hr')->__('N/A'),
                'value' => 4
            ],
        ];
        if ($withEmpty) {
            //array_unshift($options, array('label'=>'', 'value'=>''));
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
