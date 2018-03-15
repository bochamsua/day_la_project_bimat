<?php
/**
 * BS_NCR extension
 * 
 * @category       BS
 * @package        BS_NCR
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Status
 *
 * @category    BS
 * @package     BS_NCR
 * @author Bui Phong
 */
class BS_Cmr_Model_Cmr_Attribute_Source_Cmrstatus
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
                'label' => Mage::helper('bs_cmr')->__('Open'),
                'value' => 0
            ),
            array(
                'label' => Mage::helper('bs_cmr')->__('Close'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('bs_cmr')->__('Overdue'),
                'value' => 2
            ),
	        array(
		        'label' => Mage::helper('bs_cmr')->__('Late Close'),
		        'value' => 3
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
