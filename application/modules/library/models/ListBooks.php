<?php

class Library_Model_ListBooks {
    public function listBooks() {
        //you have already in application.ini the declared
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectBooks = new Zend_Db_Select($db);
        //create the quey to grab all of the books
        $selectBooks->from('books');
        
        return $selectBooks;
    }
    
}