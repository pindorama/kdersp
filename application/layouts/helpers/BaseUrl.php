<?php

/*
 * when you dont have a Viewhelper you can wriete one here in this folder 
 */

class Zend_View_Helper_BaseUrl {
    //you can put the url everywhere in the project
    function  baseUrl() {
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
    }
    
}
?>
