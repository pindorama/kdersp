<?php

class Library_BooksController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }


     public function listAction()
    {
        // action body
        $booksTBL = new Library_Model_DbTable_Books();
        $this->view->albums = $booksTBL->fetchAll();
    }


}









