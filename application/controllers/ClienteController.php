<?php

class ClienteController extends Tokem_ControllerBase
{

    protected $_clientes = null;
    protected $_endereco = null;
    protected $_anamnese = null;
    protected $_antecedentes = null;
    protected $_habitos = null;
    protected $_perimetria = null;
    protected $_inspecao = null;
    protected $_sensibilidade = null;
    protected $_tratamentos = null;

    protected $_dbAdapter = null;

    public function init()
    {
        parent::init();
        $this->_clientes = new Application_Model_Clientes();
        $this->_endereco = new Application_Model_Endereco();
        $this->_anamnese = new Application_Model_Anamnese();
        $this->_antecedentes = new Application_Model_Antecedentes();
        $this->_habitos = new Application_Model_Habitos();
        $this->_perimetria = new Application_Model_Perimetria();
        $this->_inspecao = new Application_Model_Inspecao();
        $this->_sensibilidade = new Application_Model_Sensibilidade();
        $this->_tratamentos = new Application_Model_Tratamento();


        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
        //$this->_notification = new Tokem_Notification();
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();
    }

    public function indexAction()
    {
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/jquery.dataTables.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/ZeroClipboard.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/TableTools.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/datatable/dataTables.bootstrap_03.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/js/maskmoney.min.js');

        $listUsers = $this->_clientes->fetchAll("cli_tipo = 2",null);
      
       /*remover pagination não esta sendo usado*/
        $paginator = Zend_Paginator::factory($listUsers);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(500);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->paginator = $paginator;
    }

    public function cadastrarAction()
    {
       $form = new Application_Form_Cliente();
       $form->setAction($this->_helper->url('cadastrar'));

        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            $this->_dbAdapter->beginTransaction();
            $dados = $form->getValues();

            try {
                
                $dados['cli_data_cadastro'] = date('Y-m-d');
//                $senha = $dados['cli_senha'];
//                $nome = $dados['cli_nome'];
                $dados['cli_senha'] = md5($dados['cli_senha']);


                // formata data para o banco
                $aux = explode('/', $dados['cli_data_nasc']);
                $dados['cli_data_nasc'] = $aux[2] . "-".$aux[1]."-".$aux[0];
                
                $lastId = $this->_clientes->insert($dados);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Paciente cadastrado!</strong>
                                                Paciente cadastrado com sucesso!
                                                </div>');
                
                $this->_redirect('/cliente/ficha/id/' . $lastId);
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
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

        $this->view->formCliente = $form;
    }


    public function editarAction(){

        $form = new Application_Form_Cliente();

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');

        $dados = $this->getRequest()->getParams();

        /* Dados para popular o formulario */
        /* Seta a ação do formulario */
        $form->setAction($this->_helper->url('editar/id/' . $id));

        /* Modifica o botão de criar para editar */
        //$form->getElement('btnusuario')->setAttribs(array('name' => 'edit', 'id' => 'edit','class'=>'btn btn-success'))->setLabel('Editar cliente');

        /* Obtem um unico usuário através do id passado */
        $cliente = $this->_clientes->find($id)->current();

        /* Formata as datas vindas do banco */
        $data = $cliente->cli_data_nasc;
        $format = Zend_Date::DATETIME_MEDIUM;
        $date = new Zend_Date();
        $date->set($data)->get($format);
        $cliente['cli_data_nasc'] = date('d/m/Y', strtotime($data));

        /* Popula o formulario com os valores retornados do banco */
        $form->populate($cliente->toArray());



        if (!$dados['cli_senha']) {
            $form->getElement('cli_senha')->setRequired(false);
            $form->getElement('repeatpassword')->setRequired(false);
        }

        $request = $this->getRequest();


        if ($request->isPost() && $form->isValid($request->getPost())) {

            try {


                $aux = explode('/', $dados['cli_data_nasc']);
                $dados['cli_data_nasc'] = $aux[2] . "-".$aux[1]."-".$aux[0];

                $cliente->cli_idade = $dados['cli_idade'];
                $cliente->cli_telefone = $dados['cli_telefone'];
                $cliente->cli_profissao = $dados['cli_profissao'];
                $cliente->cli_cpf = $dados['cli_cpf'];
                $cliente->cli_indicacao = $dados['cli_indicacao'];
                $cliente->cli_anotacao = $dados['cli_anotacao'];
                $cliente->cli_nome = $dados['cli_nome'];
                $cliente->cli_email = $dados['cli_email'];
                $cliente->cli_data_cadastro = $cliente->cli_data_cadastro;
                $cliente->cli_ativo = $cliente->cli_ativo;
                

                if ($dados['cli_senha']) {
                    $senha = $dados['cli_senha'];
                    $cliente->cli_senha = md5($dados['cli_senha']);
                }

                $cliente->save();
                $nome = $dados['cli_nome'];
                
                 $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Paciente editado!</strong>
                                                Paciente editado com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
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
            $this->view->formCliente = $form;

        
    }
    

   public function anamneseAction(){

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $anamnese = $this->_anamnese->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($anamnese)){


        try {


                $anamnese->ana_queixa_principal=$dados["ana_queixa_principal"];
                $anamnese->ana_diagnostico_clinico=$dados["ana_diagnostico_clinico"];
                $anamnese->ana_diagnostico_cinetico_funcional=$dados["ana_diagnostico_cinetico_funcional"];
                $anamnese->ana_hda=$dados["ana_hda"];
                $anamnese->ana_medico_responsavel=$dados["ana_medico_responsavel"];
                $anamnese->ana_peso=$dados["ana_peso"];
                $anamnese->ana_consideracoes=$dados["ana_consideracoes"];
                
                $anamnese->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Anamnese editada!</strong>
                                                Anamnese editada com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert fade in">
                                                <button class="close" data-dismiss="alert" type="button">x</button>
                                                <strong>Ocorreu um erro!</strong>
                                                Se o erro persistir entre em contato com o suporte!
                                                </div>');

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $anamnese=array(
                "ana_queixa_principal"=>$dados["ana_queixa_principal"],
                "ana_diagnostico_clinico"=>$dados["ana_diagnostico_clinico"],
                "ana_diagnostico_cinetico_funcional"=>$dados["ana_diagnostico_cinetico_funcional"],
                "ana_hda"=>$dados["ana_hda"],
                "ana_hf"=>$dados["ana_hf"],
                "ana_medico_responsavel"=>$dados["ana_medico_responsavel"],
                "ana_peso"=>$dados["ana_peso"],
                "ana_consideracoes"=>$dados["ana_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_anamnese->insert($anamnese);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Anamnese adicionada!</strong>
                                                Anamnese adicionada com sucesso!
                                                </div>');
                
                $this->_redirect('/cliente/ficha/id/' . $id);
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
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


   }


   public function enderecoAction(){

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $endereco = $this->_endereco->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($endereco)){


        try {


                $endereco->end_logradouro=$dados["end_logradouro"];
                $endereco->end_numero=$dados["end_numero"];
                $endereco->end_bairro=$dados["end_bairro"];
                $endereco->end_cidade=$dados["end_cidade"];
                $endereco->end_estado=$dados["end_estado"];
                $endereco->end_cep=$dados["end_cep"];
                $endereco->end_complemento=$dados["end_complemento"];
                
                $endereco->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Endereço editado!</strong>
                                                Endereço editado com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

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

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $endereco=array(
                "end_logradouro"=>$dados["end_logradouro"],
                "end_numero"=>$dados["end_numero"],
                "end_bairro"=>$dados["end_bairro"],
                "end_cidade"=>$dados["end_cidade"],
                "end_estado"=>$dados["end_estado"],
                "end_cep"=>$dados["end_cep"],
                "end_complemento"=>$dados["end_complemento"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_endereco->insert($endereco);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Endereço adicionado!</strong>
                                                Endereço adicionado com sucesso!
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


   }

   public function antecedentesAction(){

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $antecedentes = $this->_antecedentes->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($antecedentes)){


        try {


                $antecedentes->ant_anticoncepcionais_hormonais=$dados["ant_anticoncepcionais_hormonais"];
                $antecedentes->ant_tratamento_medico=$dados["ant_tratamento_medico"];
                $antecedentes->ant_antecedentes_cirurgicos=$dados["ant_antecedentes_cirurgicos"];
                $antecedentes->ant_gestate=$dados["ant_gestate"];
                $antecedentes->ant_alergias=$dados["ant_alergias"];
                $antecedentes->ant_alteracoes_dermatologicas=$dados["ant_alteracoes_dermatologicas"];
                $antecedentes->ant_alteracoes_neurologicas=$dados["ant_alteracoes_neurologicas"];
                $antecedentes->ant_alteracoes_respiratorias=$dados["ant_alteracoes_respiratorias"];
                $antecedentes->ant_alteracoes_urinarias=$dados["ant_alteracoes_urinarias"];
                $antecedentes->ant_neoplasias=$dados["ant_neoplasias"];
                $antecedentes->ant_diabetes=$dados["ant_diabetes"];
                $antecedentes->ant_epilepsia=$dados["ant_epilepsia"];
                $antecedentes->ant_hipertensao=$dados["ant_hipertensao"];
                $antecedentes->ant_ciclo_menstrual_regular=$dados["ant_ciclo_menstrual_regular"];
                $antecedentes->ant_varizes=$dados["ant_varizes"];
                $antecedentes->ant_consideracoes=$dados["ant_consideracoes"];
                
                $antecedentes->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Antecedentes editados!</strong>
                                                Antecedentes editados com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

            } catch (Zend_Db_Exception $e) {
                
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert fade in">
                                                <button class="close" data-dismiss="alert" type="button">x</button>
                                                <strong>Ocorreu um erro!</strong>
                                                Se o erro persistir entre em contato com o suporte!
                                                </div>');

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $antecedentes=array(
                "ant_anticoncepcionais_hormonais"=>$dados["ant_anticoncepcionais_hormonais"],
                "ant_tratamento_medico"=>$dados["ant_tratamento_medico"],
                "ant_antecedentes_cirurgicos"=>$dados["ant_antecedentes_cirurgicos"],
                "ant_gestate"=>$dados["ant_gestate"],
                "ant_alergias"=>$dados["ant_alergias"],
                "ant_alteracoes_dermatologicas"=>$dados["ant_alteracoes_dermatologicas"],
                "ant_alteracoes_neurologicas"=>$dados["ant_alteracoes_neurologicas"],
                "ant_alteracoes_respiratorias"=>$dados["ant_alteracoes_respiratorias"],
                "ant_alteracoes_urinarias"=>$dados["ant_alteracoes_urinarias"],
                "ant_neoplasias"=>$dados["ant_neoplasias"],
                "ant_diabetes"=>$dados["ant_diabetes"],
                "ant_epilepsia"=>$dados["ant_epilepsia"],
                "ant_hipertensao"=>$dados["ant_hipertensao"],
                "ant_ciclo_menstrual_regular"=>$dados["ant_ciclo_menstrual_regular"],
                "ant_varizes"=>$dados["ant_varizes"],
                "ant_consideracoes"=>$dados["ant_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_antecedentes->insert($antecedentes);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Antecedentes adicionados!</strong>
                                                Antecedentes adicionados com sucesso!
                                                </div>');
                
                $this->_redirect('/cliente/ficha/id/' . $id);
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
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

    
   }

   public function habitosAction(){
        
         /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $habitos = $this->_habitos->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($habitos)){


        try {

                $habitos->hab_fumo=$dados["hab_fumo"];
                $habitos->hab_bebida_alcoolica=$dados["hab_bebida_alcoolica"];
                $habitos->hab_atividade_fisica=$dados["hab_atividade_fisica"];
                $habitos->hab_alimentacao=$dados["hab_alimentacao"];
                $habitos->hab_ingestao_de_liguidos=$dados["hab_ingestao_de_liguidos"];
                $habitos->hab_sono=$dados["hab_sono"];
                $habitos->hab_consideracoes=$dados["hab_consideracoes"];
                
                $habitos->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Antecedentes editados!</strong>
                                                Antecedentes editados com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert fade in">
                                                <button class="close" data-dismiss="alert" type="button">x</button>
                                                <strong>Ocorreu um erro!</strong>
                                                Se o erro persistir entre em contato com o suporte!
                                                </div>');

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $habitos=array(
                "hab_fumo"=>$dados["hab_fumo"],
                "hab_bebida_alcoolica"=>$dados["hab_bebida_alcoolica"],
                "hab_atividade_fisica"=>$dados["hab_atividade_fisica"],
                "hab_alimentacao"=>$dados["hab_alimentacao"],
                "hab_ingestao_de_liguidos"=>$dados["hab_ingestao_de_liguidos"],
                "hab_sono"=>$dados["hab_sono"],
                "hab_consideracoes"=>$dados["hab_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_habitos->insert($habitos);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Habitos adicionados!</strong>
                                                Habitos adicionados com sucesso!
                                                </div>');
                
                $this->_redirect('/cliente/ficha/id/' . $id);
                exit;
                
            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
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


   }

   public function perimetriaAction(){
         /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $perimetria = $this->_perimetria->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($perimetria)){


        try {


                $perimetria->per_busto=$dados["per_busto"];
                $perimetria->per_cicatriz_umbilical=$dados["per_cicatriz_umbilical"];
                $perimetria->per_cintura=$dados["per_cintura"];
                $perimetria->per_5_cm_acima=$dados["per_5_cm_acima"];
                $perimetria->per_gluteos=$dados["per_gluteos"];
                $perimetria->per_mse_braco=$dados["per_mse_braco"];
                $perimetria->per_mse_antebraco=$dados["per_mse_antebraco"];
                $perimetria->per_msd_braco=$dados["per_msd_braco"];
                $perimetria->per_msd_antebraco=$dados["per_msd_antebraco"];
                $perimetria->per_mie_coxa=$dados["per_mie_coxa"];
                $perimetria->per_mie_perna=$dados["per_mie_perna"];
                $perimetria->per_mid_coxa=$dados["per_mid_coxa"];
                $perimetria->per_mid_perna=$dados["per_mid_perna"];
                $perimetria->per_consideracoes=$dados["per_consideracoes"];
                
                $perimetria->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Perimetria editada!</strong>
                                                Perimetria editada com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

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

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $perimetria=array(
                "per_busto"=>$dados["per_busto"],
                "per_cicatriz_umbilical"=>$dados["per_cicatriz_umbilical"],
                "per_cintura"=>$dados["per_cintura"],
                "per_5_cm_acima"=>$dados["per_5_cm_acima"],
                "per_gluteos"=>$dados["per_gluteos"],
                "per_mse_braco"=>$dados["per_mse_braco"],
                "per_mse_antebraco"=>$dados["per_mse_antebraco"],
                "per_msd_braco"=>$dados["per_msd_braco"],
                "per_msd_antebraco"=>$dados["per_msd_antebraco"],
                "per_mie_coxa"=>$dados["per_mie_coxa"],
                "per_mie_perna"=>$dados["per_mie_perna"],
                "per_mid_coxa"=>$dados["per_mid_coxa"],
                "per_mid_perna"=>$dados["per_mid_perna"],
                "per_consideracoes"=>$dados["per_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_perimetria->insert($perimetria);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Perimetria adicionada!</strong>
                                                Perimetria adicionada com sucesso!
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

   }


   public function inspecaoAction(){

        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $inspecao = $this->_inspecao->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($inspecao)){


        try {


                $inspecao->ins_consideracoes=$dados["ins_consideracoes"];
                
                
                $inspecao->save();
                
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Inspeção editada!</strong>
                                                Inspeção editada com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

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

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $inspecao=array(
                "ins_consideracoes"=>$dados["ins_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_inspecao->insert($inspecao);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Inspeção adicionada!</strong>
                                                Inspeção adicionada com sucesso!
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
    
   }

   public function sensibilidadeAction(){

    /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $request = $this->getRequest();
        $sensibilidade = $this->_sensibilidade->fetchRow("cli_codigo_fk='$id' ", null);
        $dados = $this->getRequest()->getParams();
        
    if(isset($sensibilidade)){


        try {

                $sensibilidade->sen_tatil=$dados["sen_tatil"];
                $sensibilidade->sen_termica=$dados["sen_termica"];
                $sensibilidade->sen_dolorosa=$dados["sen_dolorosa"];
                $sensibilidade->sen_consideracoes=$dados["sen_consideracoes"];
                $sensibilidade->save();
                
                $this->_helper->flashMessenger('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Sensibilidade editada!</strong>
                                                Sensibilidade editada com sucesso!
                                                </div>');
                
                    $this->_redirect('/cliente/ficha/id/' .$id);
                    

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

                $this->_redirect('/cliente/ficha/id/' .$id);
            }


       
    }else{

        if ($request->isPost()) {

            $this->_dbAdapter->beginTransaction();

            $sensibilidade=array(
                "sen_tatil"=>$dados["sen_tatil"],
                "sen_termica"=>$dados["sen_termica"],
                "sen_dolorosa"=>$dados["sen_dolorosa"],
                "sen_consideracoes"=>$dados["sen_consideracoes"],
                "cli_codigo_fk"=>$id,
            );

            try {
                
                
                $lastId = $this->_sensibilidade->insert($sensibilidade);

                $this->_dbAdapter->commit();
                
                
                $flashMessenger = $this->_helper->FlashMessenger;
                $flashMessenger->addMessage('<div class="alert  alert-info fade in">
                                                <button class="close" data-dismiss="alert" type="button">×</button>
                                                <strong>Sensibilidade adicionada!</strong>
                                                Sensibilidade adicionada com sucesso!
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
        
   }
 
    
    public function fichaAction(){

        $formCliente = new Application_Form_Cliente();
        $formEndereco = new Application_Form_Endereco();
        
        $formAnamnese = new Application_Form_Anamnese();
        $formAntecedentes = new Application_Form_Antecedentes();
        $formHabitos = new Application_Form_Habitos();
        $formPerimetria = new Application_Form_Perimetria();
        $formInspecao = new Application_Form_Inspecao();
        $formSensibilidade = new Application_Form_Sensibilidade();
        $formTratamento = new Application_Form_Tratamento();
        
        $formCliente->setAction($this->_helper->url('edit'));

        /*Populate Cliente*/
        /* Obtem o valor passado por $_GET */
        $id = (int) $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();

        /* Dados para popular o formulario */
        /* Seta a ação do formulario */
        $formCliente->setAction($this->_helper->url('editar/id/' . $id));
        $formAnamnese->setAction($this->_helper->url('anamnese/id/' . $id));
        $formAntecedentes->setAction($this->_helper->url('antecedentes/id/' . $id));
        $formHabitos->setAction($this->_helper->url('habitos/id/' . $id));
        $formPerimetria->setAction($this->_helper->url('perimetria/id/' . $id));
        $formInspecao->setAction($this->_helper->url('inspecao/id/' . $id));
        $formSensibilidade->setAction($this->_helper->url('sensibilidade/id/' . $id));
        $formTratamento->setAction($this->_baseUrl."/tratamento/adicionar");
        $formEndereco->setAction($this->_baseUrl."/cliente/endereco/id/".$id);


        $formTratamento->getElement('id')->setValue($id);

        /* Modifica o botão de criar para editar */
        //$form->getElement('btnusuario')->setAttribs(array('name' => 'edit', 'id' => 'edit','class'=>'btn btn-success'))->setLabel('Editar cliente');

        /* Obtem um unico usuário através do id passado */
        $cliente = $this->_clientes->find($id)->current();

        $anamnese = $this->_anamnese->fetchRow("cli_codigo_fk='$id'");
        $endereco = $this->_endereco->fetchRow("cli_codigo_fk='$id'");
        $antecedentes = $this->_antecedentes->fetchRow("cli_codigo_fk='$id'");
        $habitos = $this->_habitos->fetchRow("cli_codigo_fk='$id'");
        $perimetria = $this->_perimetria->fetchRow("cli_codigo_fk='$id'");
        $inspecao = $this->_inspecao->fetchRow("cli_codigo_fk='$id'");
        $sensibilidade = $this->_sensibilidade->fetchRow("cli_codigo_fk='$id'");

        /* Formata as datas vindas do banco */
        $data = $cliente->cli_data_nasc;
        $format = Zend_Date::DATETIME_MEDIUM;
        $date = new Zend_Date();
        $date->set($data)->get($format);
        $cliente['cli_data_nasc'] = date('d/m/Y', strtotime($data));

        /* Popula o formulario com os valores retornados do banco */
        $formCliente->populate($cliente->toArray());

        if(isset($anamnese)){
           $formAnamnese->populate($anamnese->toArray());            
        }

        if(isset($endereco)){
           $formEndereco->populate($endereco->toArray());            
        }

        if(isset($antecedentes)){
           $formAntecedentes->populate($antecedentes->toArray());            
        }

        if(isset($habitos)){
           $formHabitos->populate($habitos->toArray());            
        }

        if(isset($perimetria)){
           $formPerimetria->populate($perimetria->toArray());            
        }

        if(isset($inspecao)){
           $formInspecao->populate($inspecao->toArray());            
        }

        if(isset($sensibilidade)){
           $formSensibilidade->populate($sensibilidade->toArray());            
        }

        /*CADASTRAR*/
        
        $this->view->pacienteNome = $cliente->cli_nome;
        $this->view->pacienteCodigo = $cliente->cli_codigo;


        $this->view->formEndereco = $formEndereco;
        $this->view->formAntecedentes = $formAntecedentes;
        $this->view->formAnamnese = $formAnamnese;
        $this->view->formCliente = $formCliente;
        $this->view->formHabitos = $formHabitos;
        $this->view->formPerimetria = $formPerimetria;
        $this->view->formInspecao = $formInspecao;
        $this->view->formSensibilidade = $formSensibilidade;
        $this->view->formTratamento = $formTratamento;
        $this->view->tratamentos = $this->_tratamentos->getAll($id);

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

    public function tratamentoAction(){
        
    }


    public function listarAction()
    {
        // action body
    }


}