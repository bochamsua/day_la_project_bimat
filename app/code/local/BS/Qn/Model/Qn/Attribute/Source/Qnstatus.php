<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * Admin source model for Status
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Model_Qn_Attribute_Source_Qnstatus
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
                'label' => Mage::helper('bs_qn')->__('Not Submitted'),
                'value' => 0
            ),
            array(
                'label' => Mage::helper('bs_qn')->__('Not signed'),
                'value' => 1
            ),
            array(
                'label' => Mage::helper('bs_qn')->__('Signed'),
                'value' => 2
            ),
            array(
                'label' => Mage::helper('bs_qn')->__('Closed'),
                'value' => 3
            ),
	        array(
		        'label' => Mage::helper('bs_qn')->__('Overdue'),
		        'value' => 4
	        ),
	        array(
		        'label' => Mage::helper('bs_qn')->__('Late Close'),
		        'value' => 5
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
