<?php

class FinanceiroController extends Tokem_ControllerBase
{

    protected $_clientes = null;
    protected $_tratamentos = null;
    protected $_tratamentosPacientes = null;
    protected $_dbAdapter = null;

    public function init()
    {
        parent::init();

        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
        //$this->_notification = new Tokem_Notification();
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();


        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/jquery.dataTables.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/ZeroClipboard.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/TableTools.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/dataTables.bootstrap_03.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/maskmoney.min.js');

        $this->view->headScript()->appendFile($this->_baseUrl . '/bootstrapvalidator/dist/js/bootstrapValidator.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/bootstrapvalidator/src/js/language/pt_BR.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/financeiro.js');

        $this->view->headLink()->appendStylesheet('/dermobook/public/bootstrapvalidator/dist/css/bootstrapValidator.min.css');

    }


    public function indexAction(){

    }

    public function adicionarAction(){

    }

    public function editarAction(){

    }


    public function excluirAction(){

    }


    public function visualizarAction(){

    }


}    