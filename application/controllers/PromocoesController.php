<?php

class PromocoesController extends Zend_Controller_Action
{

    protected $_dbAdapter = null;
    protected $_promocoes = null;

    public function init()
    {
        
    }


    public function indexAction(){
        $this->_helper->layout->disableLayout();
    }

    public function adicionarAction(){

        $this->_promocoes = new Application_Model_Promocoes();

        $nome = $_POST['dermo_nome'];
        $email = $_POST['dermo_email'];
        $telefone = $_POST['dermo_telefone'];
        $sexo = $_POST['dermo_sexo'];

        $promocoes = array(
            "pro_nome"=>$nome,
            "pro_email"=>$email,
            "pro_telefone"=>$telefone,
            "pro_sexo"=>$sexo,
            "pro_data_cadastro"=>date('Y-m-d'),
        );


        $emailExiste = $this->_promocoes->fetchRow("pro_email='$email'");
        $telefoneExiste = $this->_promocoes->fetchRow("pro_telefone='$telefone'");
        
        if(isset($emailExiste)){
          @$mensagens  = "Email já existe! \n";
        }if(isset($telefoneExiste)){
          @$mensagens = @$mensagens . "Telefone já existe!";
        }

        if(!isset($mensagens)){
            try {

                $this->_promocoes->insert($promocoes);
                echo 1;
                exit;
                
            } catch (Zend_Db_Exception $e) {

                echo $e->getMensage();
                exit;
                
            } 
        }else{
            echo $mensagens ;
            exit;
        }


    }


    public function listarAction(){
        $this->_helper->layout->disableLayout();
        $this->_promocoes = new Application_Model_Promocoes();
        $participantes = $this->_promocoes->fetchAll();        
        $this->view->participantes = $participantes;
    }

    public function sortearAction(){

        $this->_promocoes = new Application_Model_Promocoes();
        $participantes = $this->_promocoes->getAll();

        foreach ($participantes as $participante){
            echo "Ganhador | Nome:". $participante["pro_nome"] . " Telefone:".$participante["pro_telefone"]."\n" ;
        }
        exit();

    }


}    