<?php
class Model_LibraryAcl extends Zend_Acl{
    public function __construct() {
        
        /*
         * Roles
         */
        $this->addRole(new Zend_Acl_Role('guests'));
        $this->addRole(new Zend_Acl_Role('users'), 'guests');
        $this->addRole(new Zend_Acl_Role('admins'), 'users');
        /*
         * Resources
         */
        //create a top level resource for libray(module)
        $this->add(new Zend_Acl_Resource('library'))
                //inherit vom library above, books ist the controller von library
                ->add(new Zend_Acl_Resource('library:books'), 'library');
        //create a top level resource for admin(module)        
        $this->add(new Zend_Acl_Resource('admin'))
                   //inherit vom library above, book ist the controller from admin
            ->add(new Zend_Acl_Resource('admin:book'), 'admin');
        
        $this->add(new Zend_Acl_Resource('default'))
                //inherit from default above, that's you have 'default',authentication is the controller
                ->add(new Zend_Acl_Resource('default:authentication'),'default')
                ->add(new Zend_Acl_Resource('default:index'),'default')
                ->add(new Zend_Acl_Resource('default:error'),'default');
        
         /*
          * Privileges
          */
        //allow 'guest' loowest privileges to the top, we allowed guest to do login on the authentication
        //role = guests, module = default, controller= authentication, what it is trying to do with the action= login
          $this->allow('guests','default:authentication','login');
        //show the errors
         // $this->allow('guests','default:error','error');
          //you dont users login twice
          
          $this->allow('guests','default:authentication','login');
          $this->allow('guests','default:error','error');
          
           $this->deny('users','default:authentication','login');
           $this->allow('users','default:index','index');
           $this->allow('users','default:authentication','logout');
           //array allow user to see 'index' and 'list' views from controller books, arra =views
           $this->allow('users', 'library:books', array('index', 'list'));
           
           $this->allow('admins','admin:book', array('index','add','edit','delete'));
}

    }