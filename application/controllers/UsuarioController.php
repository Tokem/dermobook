<?php

class UsuarioController extends Tokem_ControllerBase
{

    protected $_clientes = null;
    protected $_logs = null;
    
    protected $_notification = null;
    protected $_dbAdapter = null;

    public function init()
    {
        parent::init();
        $this->_clientes = new Application_Model_Clientes();
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/jquery.dataTables.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/ZeroClipboard.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/TableTools.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/dataTables.bootstrap_03.js');

        $listUsers = $this->_clientes->fetchAll("cli_tipo = 1",null);
      
       /*remover pagination não esta sendo usado*/
        $paginator = Zend_Paginator::factory($listUsers);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(50);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->paginator = $paginator;
    }
   
    public function cadastrarAction()
    {
       $form = new Application_Form_Usuario();
       $form->setAction($this->_helper->url('cadastrar'));

        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            $this->_dbAdapter->beginTransaction();
                
            $dados = $form->getValues();
            try {
                
                $dados['cli_data_cadastro'] = date('Y-m-d');
                $senha = $dados['cli_senha'];
                $nome = $dados['cli_nome'];
                $dados['cli_senha'] = md5($dados['cli_senha']);

                $this->_clientes->insert($dados);
                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Usuário cadastrado!</strong>
                                                Usuário cadastrado com sucesso!
                                                </div>');
                
                $this->_helper->redirector('index');
                
            } catch (Zend_Db_Exception $e) {
                
                //echo $e->getMessage();
                //exit;
                
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

        $this->view->formUsuario = $form;
    }
    
    
    public function emailAction()
    {   
         $request = $this->getRequest();
        
        if ($request->isXmlHttpRequest()) {
            try {
                
                $dados = $this->getRequest()->getParams();
                $email =$dados['cli_email'];
                
                /* Obtem um unico usuÃƒÂ¡rio atravÃƒÂ©s do id passado */
                $cliente = $this->_clientes->findByEmail($email);
                
                if($cliente){
                    echo false;
                }else{
                    echo true;
                }
                
            } catch (Zend_Db_Exception $e) {
                echo "<pre>".$e->getMessage()."</pre>";
                //echo "error";
                exit;
            }
        }
         
        exit;
        
    }
    
    public function editarAction() {
        
        $form = new Application_Form_Usuario();

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');

        $dados = $this->getRequest()->getParams();

        /* Dados para popular o formulario */
        /* Seta a ação do formulario */
        $form->setAction($this->_helper->url('editar/id/' . $id));

        /* Modifica o botão de criar para editar */
        $form->getElement('btnusuario')->setAttribs(array('name' => 'edit', 'id' => 'edit','class'=>'btn btn-success'))->setLabel('Editar usuario');

        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_clientes->find($id)->current();

        /* Popula o formulario com os valores retornados do banco */
        $form->populate($usuario->toArray());



        if (!$dados['cli_senha']) {
            $form->getElement('cli_senha')->setRequired(false);
            $form->getElement('repeatpassword')->setRequired(false);
        }

        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost())) {

            try {

                $usuario->cli_nome = $dados['cli_nome'];
                $usuario->cli_email = $dados['cli_email'];
                $usuario->cli_permissao = $dados['cli_permissao'];
                $usuario->cli_data_cadastro = $usuario->cli_data_cadastro;
                $usuario->cli_ativo = $usuario->cli_ativo;
                

                if ($dados['cli_senha']) {
                    $senha = $dados['cli_senha'];
                    $usuario->cli_senha = md5($dados['cli_senha']);
                }

                $usuario->save();
                $nome = $dados['cli_nome'];
                
                 $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Usuário editado!</strong>
                                                Usuário editado com sucesso!
                                                </div>');
                $this->_helper->redirector('index');
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

        $this->view->formUsuario = $form;
    
    }

    public function visualizarAction()
    {
        $form = new Application_Form_Usuario();

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');

        /* Dados para popular o formulario */
        /* Seta a ação do formulario */
        $form->setAction($this->_helper->url('editar/id/' . $id));
        
        /*Bloqueamos os elementos*/
        
        $form->getElement('cli_nome')->setAttrib('disable','disable');
        $form->getElement('cli_telefone')->setAttrib('disable','disable');
        $form->getElement('cli_email')->setAttrib('disable','disable');
        
        $form->getElement('repeatpassword')->setAttrib('disable','disable');
        $form->getElement('cli_permissao')->setAttrib('disable','disable');
        
        $form->removeElement('btnusuario');
        $form->removeElement('repeatpassword');
        $form->removeElement('cli_senha');
        $form->removeElement('cli_senha');       
        
        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_clientes->find($id)->current();       

        /* Popula o formulario com os valores retornados do banco */
        $form->populate($usuario->toArray());

        $this->view->formUsuario = $form;
    }

    public function excluirAction()
    {
        $form = new Application_Form_Usuario();

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');

        /* Dados para popular o formulario */
        /* Seta a ação do formulario */
        $form->setAction($this->_helper->url('excluir/id/' . $id));
        
        /*Bloqueamos os elementos*/
        
        $form->getElement('cli_nome')->setAttrib('disable','disable');
        $form->getElement('cli_email')->setAttrib('disable','disable');
        $form->getElement('cli_telefone')->setAttrib('disable','disable');
        $form->getElement('repeatpassword')->setAttrib('disable','disable');
        $form->getElement('cli_permissao')->setAttrib('disable','disable');
        
        $form->removeElement('repeatpassword');
        $form->removeElement('cli_senha');
        
        /* Modifica o botão de criar para deletar */
        $form->getElement('btnusuario')->setAttribs(array('name' => 'deletetar', 'id' => 'deleteUser','class'=>'btn btn-danger'))->setLabel('Deletar usuário');
        
        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_clientes->find($id)->current();       
        
        $form->setAttrib('ref', $usuario->cli_codigo);
        
        /* Popula o formulario com os valores retornados do banco */
        $form->populate($usuario->toArray());
        
        $this->view->formUsuario = $form;
    }
    
    
    
    public function deleteAjaxAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $this->_dbAdapter->beginTransaction();
            
            try {
                
                $dados = $this->getRequest()->getParams();
                /* Obtem um unico usuário através do id passado */
                
                $usuario = $this->_clientes->find($dados['cli_codigo'])->current();    
                
                $usuario->delete();    
                
                $this->_dbAdapter->commit();
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Usuário deletado!</strong>
                                                Usuário deletado com sucesso!
                                                </div>');
                
               echo true;
               exit;
            } catch (Zend_Db_Exception $e) {
                
                $this->_dbAdapter->rollBack();
                
                $this->view->erro = 'Error when registering a user';
                exit;
            }
        }
    }

    public function logsAction()
    {
        $this->_logs = new Application_Model_Logs();
        
        $listUsers = $this->_clientes->fetchAll("cli_tipo = 1",null);

        $paginator = Zend_Paginator::factory($listUsers);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(20);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->paginator = $paginator;
    }
        
    public function logsPesquisaAction()
    {
        $this->_logs = new Application_Model_Logs();
        
        $listUsers = $this->_clientes->fetchAll("cli_tipo = 1",null);

        $paginator = Zend_Paginator::factory($listUsers);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(20);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->paginator = $paginator;
    }

    public function perfilAction()
    {
        $form = new Application_Form_Perfil();

        $clientes = new Application_Model_Clientes();
        $perfies = new Application_Model_Perfil();

        $data = $this->getRequest()->getParams();
        $idCliente = $data['id'];

        if(!$idCliente){
           $idCliente = $this->identity->cli_codigo;
        }

        $usuario = $clientes->find($idCliente)->current();
        
        $perfil = $perfies->fetchAll('duca_clientes_cli_codigo ='. $idCliente)->current();

        if(!empty($perfil)){
            $perfil->per_data_nascimento = date('d/m/Y', strtotime($perfil->per_data_nascimento));
            $perfil->per_desde = date('d/m/Y', strtotime($perfil->per_desde));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $dados = $this->getRequest()->getParams();

            $adapter = new Zend_File_Transfer_Adapter_Http();
            
            $upload = $adapter->getFileInfo();
            
            if($upload){
                $type = explode('.', $upload['imagefile']['name']);
                $type = $type[1];

                $image_hash = md5($idCliente);

                $adapter->addFilter('Rename',array('target' => "../public/upload/users/".$image_hash.".".$type, 'overwrite' => true));
                $adapter->setDestination("../public/upload/users/");
                    
                if (!$adapter->receive()) {
                    $messages = $adapter->getMessages();
                }else{
                    $usuario->cli_imagem = $image_hash .".".$type;
                    $usuario->save();
                }
            }

            if(!$upload)
            if($form->isValid($request->getPost())) {
                
                $this->_dbAdapter->beginTransaction();
                
                try {     
                    if($dados['cli_senha'])   {
                        $dados['cli_senha'] = md5($dados['cli_senha']);
                        $usuario->cli_senha = $dados['cli_senha'];
                    }                          

                    $usuario->cli_nome = $dados['cli_nome'];
                    $usuario->cli_email = $dados['cli_email'];
                    $usuario->cli_telefone = $dados['cli_telefone'];
                    
                    $usuario->save();

                    if($dados['per_data_nascimento']){
                        $aux = explode('/', $dados['per_data_nascimento']);
                        $dados['per_data_nascimento'] = $aux[2].'-'.$aux[1].'-'.$aux[0];
                        //$dados['per_data_nascimento'] = date('Y-m-d', strtotime($dados['per_data_nascimento']));
                    }

                    if($dados['per_desde']){
                        $aux = explode('/', $dados['per_desde']);
                        $dados['per_desde'] = $aux[2].'-'.$aux[1].'-'.$aux[0];
                    }

                    if(empty($perfil)){
                        $perfil = new Application_Model_Perfil();
                        $data = array('duca_clientes_cli_codigo' => $idCliente, 
                                'per_data_nascimento' => $dados['per_data_nascimento'],
                                'per_cargo' => $dados['per_cargo'], 'per_sexo' => $dados['per_sexo'],'per_filhos' => $dados['per_filhos'],
                                'per_contato_urgencia' => $dados['per_contato_urgencia'],
                                'per_desde' => $dados['per_desde'], 'per_estado_civil' => $dados['per_estado_civil']);
                        $perfil->insert($data);
                    }else{
                        $perfil->per_data_nascimento  = $dados['per_data_nascimento'];
                        $perfil->duca_clientes_cli_codigo  = $idCliente;
                        $perfil->per_cargo = $dados['per_cargo'];
                        $perfil->per_sexo = $dados['per_sexo'];
                        $perfil->per_contato_urgencia = $dados['per_contato_urgencia']; 
                        $perfil->per_desde = $dados['per_desde'];
                        $perfil->per_estado_civil = $dados['per_estado_civil'];
                        $perfil->per_filhos = $dados['per_filhos'];
                        $perfil->save();
                    }

                    $this->_dbAdapter->commit();                
                    $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                    <button class="close" data-dismiss="alert" type="button">×</button>
                                                    <strong>Usuário Atualizado com sucesso!</strong>
                                                    Usuário Atualizado com sucesso!
                                                    </div>');
                    $this->_helper->redirector('perfil');
                } catch (Zend_Db_Exception $e) {
                    
                    $this->_dbAdapter->rollBack();
                    
                    $this->view->erro = 'Error when registering a user';
                    exit;
                }
            }
        }

        $arrayUsuario = $usuario->toArray();

        $form->populate($arrayUsuario);

        if(!empty($perfil)){
            $form->populate($perfil->toArray());
        }

        $upload = new Application_Form_UploadForm();
        $this->view->upload = $upload;

        $this->view->image_perfil = $arrayUsuario['cli_imagem'];
        $this->view->form = $form;
    }

    public function listarajaxAction(){
        $this->_helper->layout()->disableLayout(); 

        $lista = $this->_clientes->fetchAll("cli_tipo = 1",null);

        echo  Zend_Json::encode($lista);
        exit();
    }
}