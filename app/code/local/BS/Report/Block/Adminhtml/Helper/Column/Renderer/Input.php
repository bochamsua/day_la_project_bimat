<?php

class BS_Report_Block_Adminhtml_Helper_Column_Renderer_Input extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{

    public function render(Varien_Object $row)
    {

        $id = $row->getId();

        $function = 'get'.ucfirst($this->getColumn()->getIndex());
        $value = $row->{$function}();

        $html = '<input type="text" ';
        $html .= 'name="'.$this->getColumn()->getIndex().'[' . $id . ']" ';
        $html .= 'value="' . $value . '"';
        $html .= 'class="input-text' . $this->getColumn()->getInlineCss() . '"/>';


        return $html;
    }
}
