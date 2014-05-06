<?php

class Library_Bootstrap extends Zend_Application_Module_Bootstrap {
    function _initSetTraslations(){
        $bootstrap = $this->getApplication();
        $layout = $bootstrap->getResource('layout');
        $view= $layout->getView();
        
        //translate Object with the adapter gettext
        $translate = new Zend_Translate('gettext', APPLICATION_PATH.'/languages/pt.mo','pt');
       // $translate->addTranslation(APPLICATION_PATH.'/languages/de.mo','de');
       
        $translate->setLocale('pt');
        //transfere the object to view
        $view->translate = $translate;
        
        
    }
    
}
?>
