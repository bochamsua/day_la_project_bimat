<?php
class BS_Theming_Model_Adminhtml_Observer
{
    public function setTheme()
    {
        $theme = 's2ltheme';
        Mage::getDesign()->setTheme($theme);
        foreach (['layout', 'template', 'skin', 'locale'] as $type) {
            Mage::getDesign()->setTheme($type, $theme);
        }
    }
}