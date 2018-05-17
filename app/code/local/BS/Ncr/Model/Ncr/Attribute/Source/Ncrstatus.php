<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Status
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Model_Ncr_Attribute_Source_Ncrstatus
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
                'label' => Mage::helper('bs_ncr')->__('Draft'),
                'value' => 0
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Processing'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Published'),
                'value' => 2
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Closed'),
                'value' => 3
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Res. Overdue'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Cancelled'),
                'value' => 5
            ],
	        [
		        'label' => Mage::helper('bs_ncr')->__('Close Late'),
		        'value' => 6
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Res. Late'),
                'value' => 7
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Overdue'),
                'value' => 8
            ],
            [
                'label' => Mage::helper('bs_ncr')->__('Ongoing'),
                'value' => 9
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
