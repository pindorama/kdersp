<?php

class Default_AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        
           $this->view->title = 'Login';
           //return instanc, check if there is a identity, if the user already login then if the user is not registed
        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('');
        }
        
        //if the request is a post, tthe data was submmited
        
        $request = $this->getRequest();
        $form = new Form_LoginForm();
        if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                $authAdapter = $this->getAuthAdapter();

                $username= $form->getValue('username');
                $password = $form->getValue('password');

                $authAdapter->setIdentity($username)
                            ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $identity = $authAdapter->getResultRowObject();

                    $authStorage = $auth ->getStorage();
                    //write the identiy in a persinten store
                    $authStorage->write($identity);

                    $this ->_redirect('http://mundodosparquinhos.local/');

                    echo 'valid';
                }  else {
                    $this->view->errorMessage =  "User name ou password is wrong!";
                    echo 'invalid';
                }
                
            }
                
        }
        
     
       $this ->view->form = $form;
       
       
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('');
    }
    
    private function getAuthAdapter() {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');
            return $authAdapter;
        
    }


}





