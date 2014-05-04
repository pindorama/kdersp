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
        // action body
        $bookList= new Library_Model_ListBooks();
        $bookListe = $bookList->listBooks();
        
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($bookListe));
        //how many pages 
        $paginator->setItemCountPerPage(3)
                //Show the page number
                    ->setCurrentPageNumber($this->_getParam('page', 1))
                    ->setPageRange(3);    
        
        $books = array();
        foreach($paginator as $book){
            $books[] = $book;
        }
        
        $this->view->books = $books;
        
        //apply the paginator to our view
        if(!$this->_request->isXmlHttpRequest()){
            $this->view->paginator = $paginator;
        } else {
            $this->view->currentPage = $paginator->getCurrentPageNumber();
        }
    }


}









