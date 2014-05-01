<?php

class Default_IndexController extends Zend_Controller_Action {

    /**
     * @var Zend_Log
     */
    private $logger;

    /**
     * the method init
     * Todo o código que queremos que seja inicializado em todos os actions
     * da aplicação poderão ser colocados ai, tais como: Configurações globais,
     *  Variáveis templae para o View, Chamada para Models, etc. 
     */
    public function init() {
        $this->logger = Zend_Registry::get('logger');
        $this->request = $this->getRequest();

        $this->view->data = array(
            array('key' => 'key_1', 'value' => 'category_1'),
            array('key' => 'key_2', 'value' => 'category_2'),
            array('key' => 'key_3', 'value' => 'category_3'),
            array('key' => 'key_4', 'value' => 'category_4'),
        );



        // passamos alguns valores para o view
        $this->view->module = $this->request->getModuleName();
        $this->view->controller = $this->request->getControllerName();
        $this->view->action = $this->request->getActionName();
    }

    public function indexAction() {
        $this->logger->log('Mensagem de debutg', Zend_Log::DEBUG);
        $this->view->headTitle('index page', 'PREPEND');
    }
    
    public function productsAction() {
 
    $produtos = array(
	1 => array( 
            'nome' => 'TV', 
	    'descricao' => 'Descrição da TV aqui'
	),
	2 => array( 
	    'nome' => 'Celular', 
	    'descricao' => 'Descrição do Celular aqui'
	),
	3 => array( 
	    'nome' => 'Notebook', 
	    'descricao' => 'Descrição do Notebook aqui'
	),
	4 => array( 
	    'nome' => 'Aparelho de Som', 
	    'descricao' => 'Descrição do Aparelho de Som aqui'
	),
    );
	
    $id = $this->request->getParam( 'id' );
	
    if( $id != false ) :
    // vamos definir os valore encontrados nas chaves do vetor
    // e passar os mesmos para o View a fim de obter
    // estes valores no arquivo produtos.phtml
    $this->view->nome = $produtos[$id]['nome'];
    $this->view->descricao = $produtos[$id]['descricao'];
    endif;
	

    }

}

