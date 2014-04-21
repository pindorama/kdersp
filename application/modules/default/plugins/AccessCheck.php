<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AcessCheck
 *
 * @author pindorama
 */
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {

    private $_acl = null;

    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        
    }

    //the Dispatch is the one put controller view and action together, preDispatch before the controller is executed.
    //get the request(controller and action) from LibraryAct
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
      //  echo 'halloo';
        //request by the user
        $module =$request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        //take the row in the dabase
       
        //isAllowed method
        if (!$this->_acl->isAllowed(Zend_Registry::get('role'), $module.':'.$controller, $action)) {
            //echo 'hi';
            //redirect to authentication and login
            $request->setControllerName('authentication')
                    ->setActionKey('login');
        }
    }

}

