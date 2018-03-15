<?php
class BS_Logger_Model_Form_Element_Username extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }

    public function getElementHtml()
    {
        $object = $this->_getObject();
          
        return Mage::getModel('admin/user')->load($this->_getObject())->getName();
    }

    protected function _getObject()
    {
        return $this->getValue();
    }

    public function getName()
    {
        return $this->getData('name');
    }
}
