<?php

class Library_Model_ListBooks {
    private $paginator = null;
    public function listBooks($page) {
        //
        /*
         * you have already in application.ini the declared,
         *  $db takes the database(zfturorial) with all tables(books,books_comments,users),
         * from the DefaultAdapter, in the application.ini we have isDefaultTableAdapter=true
         */
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectBooks = new Zend_Db_Select($db);
        //create the quey to grab all of the books
        $selectBooks->from('books');
        
        //create a object paginator with the table books from the database zfturorias
        $this->paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($selectBooks));
        //how many pages 
        $this->paginator->setItemCountPerPage(3)
                //Show the page number
                    ->setCurrentPageNumber($page)
                    ->setPageRange(3);    
        
        $books = array();
        foreach($this->paginator as $book){
            //take the the table books from the Model, using the methods add and gets
            $bookObj = new Library_Model_Book($book['id']);
            $bookObj->addTitle($book['title']);
            $bookObj->addAuthor($book['author']);
            $bookObj->addComments($this->getComments($book['id']));
            
            $books[$book['id']] = $bookObj;
            
            
        }
        
        return $books;
    }
    
    public function getPaginator(){
        return $this->paginator;
        
    }


    //JOIN Inner to compare the user id and return the comments from table books_comments, when they have the same id
    private function getComments($bookId){
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectComments = $db->select()
                            ->from('books_comments')
                            ->join('users', 'users.id = books_comments.user_id')
                            ->where('book_id = ?', $bookId);
        $comments = $db->query($selectComments)->fetchAll();
        return $comments;
    }
    
}