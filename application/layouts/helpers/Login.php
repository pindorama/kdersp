<?php

/*
 * when you dont have a Viewhelper you can wriete one here in this folder 
 */

class Zend_View_Helper_Login {
    //you can put the url everywhere in the project
    function  login() {
        $request = $this->getRequest();
        $form = new Form_LoginForm();
        
        if($request->isPost()){
            //before we going to authentication, we would to check is the identity is validad
            //we dont want any dangerous get into to authenticated, because we check already into the form
            //we going to use the form validated method
            if($form->isValid($this->_request->getPost())){
                //bring t all table information from the DB User table,the function ist getAdapeter is at the end of the page
                $authAdapter = $this->getAuthAdapter();
                   //input of the User from the website through the form
                $username= $form->getValue('username');
                $password = $form->getValue('password');
                  //you it will make the check and comparation between the username,password from form and 
                   // the username,password from DB User table, see at the end of the page, setIdentityColum and setCredentialConlumn
                //input of the User into the adapter $username and $password
                $authAdapter->setIdentity($username)
                            ->setCredential($password);
                //create a instance of auth, it does the authentication and storage in the DB
                $auth = Zend_Auth::getInstance();
                //we going to get authenticate the request through of authadapter
                $result = $auth->authenticate($authAdapter);
                
                //we will going to see, if the the authentication é success or not
                //isvalid() is a method return by authenticate($authAdapter) true or false, for example
                //if the username ou password ist wrong, ou there isn't into the DB the answer from method
                // isValid() = false
                if($result->isValid()){
                    
                    //get the entire row from table user (id,username,password,role), entänty = identitity
                    $identity = $authAdapter->getResultRowObject();
                    //we need some kind of persistent storage

                    //we get from zend_Auth::getInstance
                    $authStorage = $auth ->getStorage();
                    //write the identiy in a persinten store, by default we use zend session
                    $authStorage->write($identity);
                       //when the data (username and password) is authenticated you go to out 
                       //from authentication/login to index/index
                    $this ->_redirect('http://mundodosparquinhos.local/');
                    //username and password is correct
                    echo 'valid';
                }  else {
                    
                    $this->view->errorMessage =  "User name ou password is wrong!";
                    //username and password isn't correct, there is this name ou password in our DB Users
                    echo 'invalid';
                }
                
            }
                
        }
        
     
       $this ->view->form = $form;
    }
    
}
?>
