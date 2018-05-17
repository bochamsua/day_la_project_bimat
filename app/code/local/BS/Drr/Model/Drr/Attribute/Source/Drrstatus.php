<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Status
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Model_Drr_Attribute_Source_Drrstatus
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
                'label' => Mage::helper('bs_drr')->__('Draft'),
                'value' => 0
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Published'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Closed'),
                'value' => 2
            ],
	        [
		        'label' => Mage::helper('bs_drr')->__('Close Late'),
		        'value' => 3
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Overdue'),
                'value' => 4
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Ongoing'),
                'value' => 5
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Res. Overdue'),
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
