<?php


//the first thing thats runs in the application
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

   private $_acl = null;

    

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

   /* protected function _initViewHelpers()
{
    $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
    $view->jQuery()->addStylesheet('js/jquery/css/redmond/jquery-ui-1.10.4.custom.css')
        ->setLocalPath('/js/jquery/js/jquery-1.10.2.js')
        ->setUiLocalPath('/js/jquery/js/jquery-1.10.4.custom.min.js');
}*/
    
    protected function _initJqueryLoad()
    {

        /*$view = new Zend_View();
     // $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
//$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");


    
    
    
     $view->jQuery()->setLocalPath('/js/jquery/js/jquery-1.10.2.js')
                            ->setUiLocalPath('/js/jquery/js/jquery-1.10.4.custom.min.js')
                            ->addStylesheet('/js/jquery/css/redmond/jquery-ui-1.10.4.custom.css');
                    
    js
    ZendX_JQuery::enableView($view);*/
    }
    

    /*--------------------ViewHelper----------------------------------------------
     *the layout come not by default zend framework, we have to make manuelly ,
     * so we have to say to application.in where the layout is.
     */
  
    
    function _initViewHelpers (){
        //resoucer layout, you have in aplication ini declared
        $this->bootstrap('layout');
        //get the resoucer layout(object) from the path in aplication.ini
        $layout = $this->getResource('layout');  
        //the layout is like Zend_View work fast the same
          $view = $layout->getView();
             
             {

}
             
             /*
              * all os those view helpers are available and come from the view instance ($view
              * =layout->getView();) eg.:
              * $view->doctype('HTML4_SRITCT');
              * in the _header you can write <?php echo $this->doctype() ?>
              * 
              */
        $view->headTitle()->setSeparator(' - ');
        $view ->headTitle('Controle de Academia');
        
        //it is goin to look for any helpers specifique in modules, but if the viewhelper is not there
        //is going to look inside of this path
        $view->setHelperPath(APPLICATION_PATH.'/helpers', '');
        
          $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        // $view->jQuery()->addStylesheet('js/jquery/css/redmond/jquery-ui-1.10.4.custom.css');
        // $view->jQuery()->setLocalPath('/js/jquery/js/jquery-1.10.2.js');
       // $view->jQuery()->setUiLocalPath('/js/jquery/js/jquery-1.10.4.custom.min.js');
        //ZendX_JQuery::enableView($view);
        
      

        //i can use dojo ViewHelps in my view and layoutscripts
    //   Zend_Dojo::enableView($view);
        ;
        
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
    
    
protected function _initView()
{
    //getBaseUrl
    $this->bootstrap('frontcontroller');
    $controller = Zend_Controller_Front::getInstance();
    $baseurl =  $controller->getBaseUrl();
    
    $view = new Zend_View();
  
   // $view->baseUrl = Zend_Registry::get('config')->root_path;

    $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
    $view->jQuery()->addStylesheet($baseurl . 'js/Jquery/css/redmond/jquery-ui-1.10.4.custom.css');
    $view->jQuery()->setLocalPath($baseurl . 'js/Jquery/js/jquery-1.10.2.js');
    $view->jQuery()->setUiLocalPath($baseurl . 'js/Jquery/js/jquery-ui-1.10.4.custom.min.js');
    $view->jQuery()->enable();
    $view->jQuery()->uiEnable();
    $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    $viewRenderer->setView($view);
    Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

    return $view;
}

}