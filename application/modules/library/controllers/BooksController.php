<?php

class Library_BooksController extends Zend_Controller_Action
{

    public function init()
    {
        
        /**
         * Prepare controller to accept AJAX request using 
         * action context switcher action helper. 
         * Will generate JSON object which is picked up by jQuery front-end and applied to the page.
            For full quality, source and discussions
         */
      
        
         $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('list', 'json')
                       ->setAutoJsonSerialization(true) 
                      ->initContext();
    }

    public function indexAction()
    {
        // action body
    }


     public function listAction()
    {
        // create a object from ListBooks
        $bookList= new Library_Model_ListBooks();
        //bekome a array of books
        $books = $bookList->listBooks($this->_getParam('page', 1));
      
        $this->view->books = $books;
        //apply the paginator to our view
        if(!$this->_request->isXmlHttpRequest()){
            //problem with getPaginator
            $this->view->paginator = $bookList->getPaginator();
        } else {
            $this->view->currentPage = $bookList->getPaginator()->getCurrentPageNumber();
        }
    }


}









