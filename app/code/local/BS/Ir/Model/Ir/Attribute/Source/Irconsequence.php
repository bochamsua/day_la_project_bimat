<?php

class BS_Ir_Model_Ir_Attribute_Source_Irconsequence
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
                'label' => Mage::helper('bs_ir')->__('AOG'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_ir')->__('Delay'),
                'value' => 2
            ],
	        [
		        'label' => Mage::helper('bs_ir')->__('Human Injury'),
		        'value' => 3
            ],
	        [
		        'label' => Mage::helper('bs_ir')->__('Aircraft/ A/C component damaged'),
		        'value' => 4
            ],
	        [
		        'label' => Mage::helper('bs_ir')->__('Equipment/ Tool damaged'),
		        'value' => 5
            ],
	        [
		        'label' => Mage::helper('bs_ir')->__('Other'),
		        'value' => 6
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
