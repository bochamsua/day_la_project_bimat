<?php

class BS_Ir_Model_Ir_Attribute_Source_Irstatus
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
        $options =  array(
            array(
                'label' => Mage::helper('bs_ir')->__('Draft'),
                'value' => 0
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Processing'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Published'),
                'value' => 2
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Closed'),
                'value' => 3
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Overdued'),
                'value' => 4
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Cancelled'),
                'value' => 5
            ),
            array(
                'label' => Mage::helper('bs_ir')->__('Late Closed'),
                'value' => 6
            ),
        );
        if ($withEmpty) {
            array_unshift($options, array('label'=>'', 'value'=>''));
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
        $options = array();
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
        $texts = array();
        foreach ($value as $v) {
            if (isset($options[$v])) {
                $texts[] = $options[$v];
            }
        }
        return implode(', ', $texts);
    }
}
