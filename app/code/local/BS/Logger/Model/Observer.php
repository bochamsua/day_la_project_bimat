<?php

class BS_Logger_Model_Observer
{
    public function doLogger ($observer)
    {
        if ($this->_isLoggedIn()) {
            $logger =   $this->_getLogger();
            $request = Mage::app()->getFrontController()->getRequest();

            if($this->hasString($request->getPathInfo())){
                $params = Mage::app()->getRequest()->getParams();
                //unset($params['id']);
                unset($params['key']);
                unset($params['form_key']);

                //remove unnecessary info from pathinfo
                $info = $request->getPathInfo();

                $logger->saveLog($info,$params );
            }

        }

    }

    public function hasString($content){
        $tocheck = [
            '/reset/',
            '/save/',
            '/update/',
            '/delete/',
            '/refresh/',
            'mass',

        ];

        foreach ($tocheck as $item) {
            if(strpos($content, $item)){
                return true;
            }
        }
        return false;
    }

    protected function _isLoggedIn()
    {
        return Mage::getSingleton('admin/session')->isLoggedIn();
    }

    protected function _getLogger()
    {
        return Mage::getModel('bs_logger/logger');
    }
}