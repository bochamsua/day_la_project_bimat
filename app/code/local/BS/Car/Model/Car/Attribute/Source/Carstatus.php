<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Status
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Model_Car_Attribute_Source_Carstatus
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
                'label' => Mage::helper('bs_car')->__('Draft'),
                'value' => 0
            ],
            [
                'label' => Mage::helper('bs_car')->__('Published'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_car')->__('Closed'),
                'value' => 2
            ],
	        [
		        'label' => Mage::helper('bs_car')->__('Late Closed'),
		        'value' => 3
            ],
            [
                'label' => Mage::helper('bs_car')->__('Overdue'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_car')->__('Responded'),
                'value' => 5
            ],
            [
                'label' => Mage::helper('bs_car')->__('Res. Overdue'),
                'value' => 6
            ],
            [
                'label' => Mage::helper('bs_car')->__('Res. Late'),
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
