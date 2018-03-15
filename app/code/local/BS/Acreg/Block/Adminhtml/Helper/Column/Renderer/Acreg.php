<?php

class BS_Acreg_Block_Adminhtml_Helper_Column_Renderer_Acreg extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
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
        $base = $row->getAcReg();
        if (!$base) {
            return '';
        }

        $subject = Mage::getModel('bs_acreg/acreg')->load($base);

        return $subject->getReg();

    }
}
