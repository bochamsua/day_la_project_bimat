<?php
/**
 * BS_Formtemplate extension
 * 
 * @category       BS
 * @package        BS_Formtemplate
 * @copyright      Copyright (c) 2015
 */
/**
 * Admin source model for Revision
 *
 * @category    BS
 * @package     BS_Formtemplate
 * @author Bui Phong
 */
class BS_Formtemplate_Model_Formtemplate_Attribute_Source_Templaterevision
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
                'label' => Mage::helper('bs_formtemplate')->__('00'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('01'),
                'value' => 2
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('02'),
                'value' => 3
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('03'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('04'),
                'value' => 5
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('05'),
                'value' => 6
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('06'),
                'value' => 7
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('07'),
                'value' => 8
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('08'),
                'value' => 9
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('09'),
                'value' => 10
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('10'),
                'value' => 11
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('11'),
                'value' => 12
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('12'),
                'value' => 13
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('13'),
                'value' => 14
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('14'),
                'value' => 15
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('15'),
                'value' => 16
            ],
            [
                'label' => Mage::helper('bs_formtemplate')->__('16'),
                'value' => 17
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
