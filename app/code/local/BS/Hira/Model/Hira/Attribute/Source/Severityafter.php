<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin source model for Severity after mitigation
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Model_Hira_Attribute_Source_Severityafter
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
                'label' => Mage::helper('bs_hira')->__('A'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_hira')->__('B'),
                'value' => 2
            ],
            [
                'label' => Mage::helper('bs_hira')->__('C'),
                'value' => 3
            ],
            [
                'label' => Mage::helper('bs_hira')->__('D'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_hira')->__('E'),
                'value' => 5
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
