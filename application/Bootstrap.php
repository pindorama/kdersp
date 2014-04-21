<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

        private $_acl = null;
    protected function _initAutoload() {
        $modelLoader = new Zend_Application_Module_Autoloader(array(
            //that's why you dont need append namespace for default
            'namespace' => '',
            'basePath' => APPLICATION_PATH.'/modules/default'));
       if(Zend_Auth::getInstance()->hasIdentity()){
            Zend_Registry::set('role', Zend_Auth::getInstance()->getStorage()->read()->role);
        }else {
            //default value
            Zend_Registry::set('role', 'guests');
            
        }
        //register
        $this->_acl = new Model_LibraryAcl;
        
        //Front_Controller wird die Plugin aufrufen, bevor de
        $fc = Zend_Controller_Front::getInstance();
        //register a new plugin
        $fc->registerPlugin(new Plugin_AccessCheck($this->_acl));
        
          return $modelLoader;
    }
    function _initViewHelpers (){
        //initialize
        $this->bootstrap('layout');
        //get the object layout
        $layout = $this->getResource('layout');
        //get the layout view
        $view = $layout->getView();
        $view->setHelperPath(  APPLICATION_PATH.'/helpers', '');
        
        //come from Zend from xml to array format, nav = container
        $navContainerConfig =  new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        //create a object
        $navContainer = new Zend_Navigation($navContainerConfig);
        //push to view helper
        $view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));
                
       
                
    }
    

}

