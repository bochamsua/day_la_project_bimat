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
class BS_Misc_Block_Adminhtml_Helper_Column_Renderer_Shorter extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text
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

        $limit = intval($this->getColumn()->getLimit());
        if($limit == 0){
            $limit = 50;
        }
        $function = 'get'.ucfirst($this->getColumn()->getIndex());
        $value = $row->{$function}();

        $value = html_entity_decode($value);
        $value = $this->stripTags($value);

        return Mage::helper('core/string')->truncate($value, $limit);


    }
}
