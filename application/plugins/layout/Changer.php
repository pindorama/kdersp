<?php

class Plugin_Layout_Changer extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        //Prüft ob eine Layoutdatei in Abhängigkeit vom Modulnamen existiert
        if(is_file(Zend_Layout::getMvcInstance()->getLayoutPath()
        .$request->getModuleName().'.phtml'))
        {
            //wenn ja, dann diese setzen
            Zend_Layout::getMvcInstance()->setLayout($request->getModuleName());
        }
        else
        {
            //wenn nicht, dann Standardlayout setzen, hier: bibo
            Zend_Layout::getMvcInstance()->setLayout('bibo');
        }
    }
}
?>
