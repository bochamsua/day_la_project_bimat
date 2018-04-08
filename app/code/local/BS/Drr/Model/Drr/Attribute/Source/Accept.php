<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Accept/Reject
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Model_Drr_Attribute_Source_Accept
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
                'label' => Mage::helper('bs_drr')->__('Accept'),
                'value' => 1
            ],
            [
                'label' => Mage::helper('bs_drr')->__('Reject'),
                'value' => 2
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
