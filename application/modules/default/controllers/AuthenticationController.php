<?php

class Default_AuthenticationController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout()->setLayout('layout');
        $layout = Zend_Layout::getMvcInstance();
        

       
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {

        $this->view->title = 'Login';

//return instanc, check if there is a identity, if the user already login then if the user is not registed
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('');
        }

        //if the request is a post, tthe data was submmited

        $request = $this->getRequest();
        $form = new Form_LoginForm();

        if ($request->isPost()) {
            //before we going to authentication, we would to check is the identity is validad
            //we dont want any dangerous get into to authenticated, because we check already into the form
            //we going to use the form validated method
            if ($form->isValid($this->_request->getPost())) {
                //bring t all table information from the DB User table,the function ist getAdapeter is at the end of the page
                $authAdapter = $this->getAuthAdapter();
                //input of the User from the website through the form
                $username = $form->getValue('username');
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
                if ($result->isValid()) {

                    //get the entire row from table user (id,username,password,role), entänty = identitity
                    $identity = $authAdapter->getResultRowObject();
                    //we need some kind of persistent storage
                    //we get from zend_Auth::getInstance
                    $authStorage = $auth->getStorage();
                    //write the identiy in a persinten store, by default we use zend session
                    $authStorage->write($identity);
                    //when the data (username and password) is authenticated you go to out 
                    //from authentication/login to index/index
                    $this->_redirect('http://mundodosparquinhos.local/');
                    //username and password is correct
                    echo 'valid';
                } else {

                    $this->view->errorMessage = "User name ou password is wrong!";
                    //username and password isn't correct, there is this name ou password in our DB Users
                    echo 'invalid';
                }
            }
        }


        $this->view->form = $form;
       $this->_helper->layout()->varname = $form;
       //$this->view->placeholder('header')->append($form); 
       
        //$this ->layout->login_form = $form;
        // $layout->assign('login_form', $form);
        //Zend_Layout::getMvcInstance()->assign('whatever', 'foo');
        //Zend_Layout::getMvcInstance()->assign('nav', 'oooo');
    }

//logout erase all the session the strop in the pestintent storage
    public function logoutAction() {
        //all the authentication is now cleared
        Zend_Auth::getInstance()->clearIdentity();
        //redirect to default/index/index
        $this->_redirect('authentication/login');
    }

    //only authentication controller can use this method
    private function getAuthAdapter() {
        //Dbtable is the class connect the Zend_of and database table with the database, Zend_Db_Table instance, you in the application.ini the
        //declaration from resources the database, that was declared before
        //ZEend_Adapter passing the information
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        //layout you gonnat to tell it the information from the table field(username and password) and the table Name (users)
        $authAdapter->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password');
        //setCredentialTretment('password'); for encrypet you password
        return $authAdapter;
    }

}

