<?php

class Form_LoginForm extends Zend_Form {
    
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('login');
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('User name:')
                   ->setRequired();
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
                //VALIDATOR SHOW THE ERROR ON THE PAGE
                 ->setRequired(true);
        
        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('Login');
        
        //add elements
        $this->addElements(array($username, $password, $login));
        $this->setMethod('post');
        //pay attention hier the path Zend_Controller_Front::getInstance()->getBaseUrl() = the home path
        //submit "action" send to authentication/login
       $this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/authentication/login');
         //$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl());
    }
    
    
}
