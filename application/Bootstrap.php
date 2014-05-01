<?php


//the first thing thats runs in the application
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

   private $_acl = null;
  /* 
   protected function _initAppAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'App',
            'basePath' => dirname(__FILE__),
        ));

        return $autoloader;
    }*/
    

    protected function _initLogger()
    {
        $this->bootstrap('log');
        Zend_Registry::set('logger', $this->getResource('log'));
    }
    
    
   //This method loading at all first things  from our aplications
    protected function _initAutoload() {
        /*
         * Modules separated Admin,Default,library
         */
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
        //create a object based in library acl
        $this->_acl = new Model_LibraryAcl;
        
        
        /*
         * Register for the plugin Accesscheck, we need instance of Front Controller
         * Diese class(Front Controller) is responsible for loading all of this extras plugins
         * see Plugin AccessCheck
         * Front_Controller wird die Plugin AccessCheckl aufrufen, bevor de
         */
        
        $fc = Zend_Controller_Front::getInstance();
        //register a new plugin
        $fc->registerPlugin(new Plugin_AccessCheck($this->_acl));
        
          return $modelLoader;
    }
    
    
       protected function _initLayoutChanger()
{
    $this->bootstrap('frontController');
    $this->getResource('frontController')
         ->registerPlugin(new Plugin_Layout_Changer());
}
     protected function _initFrontControllerPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_plugins_ViewSetup());
    }
   
    
    
    
    protected function _initPartial() {
            //initialize the new ressource
        $this->bootstrap('layout');
        //get the object layout
        $layout = $this->getResource('layout');
        //get the layout View
        $view = $layout->getView();
             
         //    $view->whatever = $_form;
    }
    /*--------------------ViewHelper----------------------------------------------
     *the layout come not by default zend framework, we have to make manuelly ,
     * so we have to say to application.in where the layout is.
     */
    function _initViewHelpers (){
    
              $this->bootstrap('layout');
        //get the object layout
        $layout = $this->getResource('layout');   
            $view = $layout->getView();
             
             
             
             /*
              * all os those view helpers are available and come from the view instance ($view
              * =layout->getView();) eg.:
              * $view->doctype('HTML4_SRITCT');
              * in the _header you can write <?php echo $this->doctype() ?>
              * 
              */
        $view->headTitle()->setSeparator(' - ');
        $view ->headTitle('Controle de Academia');
        $view->setHelperPath(  APPLICATION_PATH.'/helpers', '');
        
        //come from Zend from xml to array format, nav = container
        /**
         * that only Zend class that's grab a configuration file xml new Zend_Config_Xml
         * and put it into array format, we going to grab the node 'nav' = containter, that
         * you see into the config file navigation.xml
         */
        $navContainerConfig =  new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        //create a object, you going to create the navigation
        $navContainer = new Zend_Navigation($navContainerConfig);
        //Now you going to push it  to our  Viewhelper, now the navigation you show for each role:guests,users,admins
        //different menu
        $view->navigation($navContainer)->setAcl($this->_acl)->setRole(Zend_Registry::get('role'));
                
       
                
    }
    
    
    

}

