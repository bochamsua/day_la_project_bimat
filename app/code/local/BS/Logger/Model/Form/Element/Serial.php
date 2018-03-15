<?php
class BS_Logger_Model_Form_Element_Serial extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }

    public function getElementHtml()
    {
        $value = $this->_getObject();
        $value = unserialize($value);
        $result = [];
        if(is_array($value)){
            foreach ($value as $key => $arr){
                $result[] = '<strong>'.$key.'</strong>';
                if(is_array($arr)){
                    foreach ($arr as $key1 => $item1){
                        $result[] = "----><strong>".$key1."</strong>: ".$item1;
                    }
                }else {
                    $result[] = "--><strong>".$key."</strong>: ".$arr;;
                }
            }
        }

        return implode("<br>", $result);

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
