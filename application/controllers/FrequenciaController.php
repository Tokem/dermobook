<?php

class FrequenciaController extends Tokem_ControllerBase
{

    protected $_clientes = null;
    protected $_tratamentos = null;
    protected $_tratamentosPacientes = null;
    protected $_frequencia = null;
    protected $_dbAdapter = null;

    public function init()
    {
        parent::init();
        $this->_clientes = new Application_Model_Clientes();
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
        
        


        $id = (int) $this->getRequest()->getParam('id');
        
        $frequencia = $this->_frequencia->fetchAll("tra_id_fk = $id","fre_id ASC");
        
        $this->view->frequencia = $frequencia;

    }


    public function cadastrarAction(){

        $dados = $this->getRequest()->getParams();
        $id = (int) $dados["fre_id"];


        $frequencia = $this->_frequencia->find($id)->current();

        $aux = explode('/', $dados['fre_data']);
        $data = $aux[2] . "-".$aux[1]."-".$aux[0];

        $frequencia->fre_data =$data;
        $frequencia->fre_hora =$dados["fre_hora"];
        $frequencia->fre_status =trim($dados["fre_status"]);
        $frequencia->fre_observacao =$dados["fre_observacao"];
        $frequencia->fre_ativo =1;
        
        $idFicha = $dados["tra_id_fk"];

         try {
                
                
                $frequencia->save();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Frequência adicionada!</strong>
                                                Freqência adicionada com sucesso!
                                                </div>');
                
                $this->_redirect('frequencia/index/id/'.$idFicha);
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

    public function adicionarAction(){

    }


    public function removerAction(){
        
    }


}    