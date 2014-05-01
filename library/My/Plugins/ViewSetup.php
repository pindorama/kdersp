<?php

class My_plugins_ViewSetup extends Zend_Controller_Plugin_Abstract
{
    
    
    
  public function routeShutdown($request)
  {
      //library
    $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
    $view = $bootstrap->bootstrap('view')->getResource('view');
    $view->doctype('HTML5');
 
  }
    
  
    
    
    
}
?>
