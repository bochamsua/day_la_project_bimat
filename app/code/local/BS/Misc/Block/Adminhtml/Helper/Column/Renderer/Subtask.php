<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * parent entities column renderer
 * @category   BS
 * @package    BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Helper_Column_Renderer_Subtask extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
{
    /**
     * render the column
     *
     * @access public
     * @param Varien_Object $row
     * @return string
     * @author Bui Phong
     */
	public function render(Varien_Object $row)
	{
		$base = $row->getSubtaskId();
		if (!$base) {
			return '';
		}

		$subject = Mage::getModel('bs_misc/subtask')->load($base);

		return $subject->getSubCode();

	}
}
