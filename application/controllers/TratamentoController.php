<?php

class TratamentoController extends Tokem_ControllerBase
{

    protected $_clientes = null;
    protected $_tratamentos = null;
    protected $_tratamentosPacientes = null;
    protected $_nomeTratamentos = null;
    protected $_frequencia = null;
    protected $_dbAdapter = null;

    public function init()
    {
        parent::init();
        $this->_clientes = new Application_Model_Clientes();
        $this->_tratamentos = new Application_Model_Tratamento();
        $this->_nomeTratamentos = new Application_Model_NomeTratamento();
        $this->_tratamentosPacientes = new Application_Model_TratamentoPaciente();
        $this->_frequencia = new Application_Model_Frequencia();


        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
        //$this->_notification = new Tokem_Notification();
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();
    }

    public function indexAction(){

        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/jquery.dataTables.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/ZeroClipboard.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/TableTools.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/dataTables.bootstrap_03.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/maskmoney.min.js');

        $listUsers = $this->_nomeTratamentos->fetchAll();
      
       /*remover pagination não esta sendo usado*/
        $paginator = Zend_Paginator::factory($listUsers);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(50);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->paginator = $paginator;

    }

    public function adicionarAction(){

        /* Obtem o valor passado por $_GET */
        
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();
        $id = (int) $dados["id"];
  


         if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();


            // formata data para o banco
                $aux = explode('/', $dados['tra_data_avaliacao']);
                $dados['tra_data_avaliacao'] = $aux[2] . "-".$aux[1]."-".$aux[0];

            $tratamento=array(
                "tra_nome"=>$dados["tra_nome"],
                "tra_data_avaliacao"=>$dados["tra_data_avaliacao"],
                "tra_objetivo"=>$dados["tra_objetivo"],
                "tra_valor"=>$dados["tra_valor"],
                "tra_forma_pagamento"=>$dados["tra_forma_pagamento"],
                "tra_qtd_ini"=>$dados["tra_qtd_ini"],
                "tra_consideracoes"=>$dados["tra_consideracoes"],
            );



            try {
                
                
                $lastId = $this->_tratamentos->insert($tratamento);


                $frequencia  =  array('tra_id_fk' =>$lastId );


                for($i =1;$i<=$dados["tra_qtd_ini"];$i++ ){
                    $this->_frequencia->insert($frequencia);
                    echo $i;
                }


                $tratamentoPaciente=array("cli_codigo_fk"=>$id,"tra_codigo_fk"=>$lastId);

                $this->_tratamentosPacientes->insert($tratamentoPaciente);                

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Tratamento adicionado!</strong>
                                                Tratamento adicionado com sucesso!
                                                </div>');
                
                $this->_redirect('/cliente/ficha/id/' . $id);
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                echo $e->getMessage();
                exit;
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert fade in">
                                                <button class="close" data-dismiss="alert" type="button">x</button>
                                                <strong>Ocorreu um erro!</strong>
                                                Se o erro persistir entre em contato com o suporte!
                                                </div>');

                $this->_helper->redirector('index');
            }

        }


    }

    public function nomeAction(){

         /* Obtem o valor passado por $_GET */
        
       $form = new Application_Form_NomeTratamento();
       $form->setAction($this->_helper->url('nome'));

        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();
  
         if ($request->isPost() && $form->isValid($request->getPost())) {

            $this->_dbAdapter->beginTransaction();

            $tratamento=array(
                "tra_nome"=>$dados["tra_nome"],
            );


            try {
                
                
                $lastId = $this->_nomeTratamentos->insert($tratamento);
                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Tratamento adicionado!</strong>
                                                Tratamento adicionado com sucesso!
                                                </div>');
                
                $this->_redirect('tratamento/');
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                echo $e->getMessage();
                exit;
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert fade in">
                                                <button class="close" data-dismiss="alert" type="button">x</button>
                                                <strong>Ocorreu um erro!</strong>
                                                Se o erro persistir entre em contato com o suporte!
                                                </div>');

                $this->_helper->redirector('index');
            }

        }

        $this->view->formTratamento = $form;

    }

    public function editarAction(){

    }


    public function visualizarAction(){

        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();
        $id = (int) $dados["id"];

        /* Obtem um unico usuário através do id passado */
        $tratamentos = $this->_tratamentos->find($id)->current()->toArray();
        

        $data = $tratamentos["tra_data_avaliacao"];
        $format = Zend_Date::DATETIME_MEDIUM;
        $date = new Zend_Date();
        $date->set($data)->get($format);
        $tratamentos["tra_data_avaliacao"] = date('d/m/Y', strtotime($data));

        

        echo json_encode($tratamentos);
        exit;

    }


}    