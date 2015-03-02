    <?php

class LoginController extends Tokem_ControllerBase {

    protected $_log = null;

    public function init() {
        /* Initialize action controller here */
        /* Desabilitar o layout */
        $this->_helper->layout->disableLayout();
    }

    protected function _getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $adapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $adapter->setTableName('dermo_clientes')
                ->setIdentityColumn('cli_email')
                ->setCredentialColumn('cli_senha')
                ->setCredentialTreatment('MD5(?)');
        return $adapter;
    }

    public function indexAction() {

        $request = $this->getRequest();

        if ($request->isPost() && !empty($_POST)) {

            // pega o adaptador de autenticação configurado
            $adapter = $this->_getAuthAdapter();

            // põe os dados que serão autenticados
            $adapter->setIdentity($_POST['login'])
                    ->setCredential($_POST['senha']);

           


            if($_POST['lembrar']==1){
                $authNamespace = new Zend_Session_Namespace('Zend_Auth');
                $authNamespace->user = $_POST['login'];
                $authNamespace->password = $_POST['senha'];
                $authNamespace->lembrar = $_POST['lembrar'];
            }else{
                $authNamespace = new Zend_Session_Namespace('Zend_Auth');
                unset($authNamespace->user);
                unset($authNamespace->password);
                unset($authNamespace->lembrar);
            }    


            //realiza a autenticação em si
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter); // Zend_Auth_Result


            // verifica se deu certo
            if ($result->isValid()) {
                // se der certo, pega o registro da tabela
                $usuario = $adapter->getResultRowObject();

                // grava o registro autenticado na sessão
                $auth->getStorage()->write($usuario);

                $auth = Zend_Auth::getInstance();
                $identity = $auth->getIdentity();                

                $login = array("resultado"=>"1","permissao"=>"$identity->cli_permissao");

                echo $status = json_encode($login);
                exit;

            } else {
                // se não deu certo, ver qual foi o erro
                $code = $result->getCode();
                if ($code == Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND || $code == Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID) {
                    $this->view->mensagem = 'Login or password invalid';
                    echo $this->view->mensagem = 'Login or password invalid';
                    exit;
                } else {
                    $this->view->mensagem = 'Error login';
                    echo "error 02";
                    exit;
                }
            }
        }
    }

    public function logoutAction() {
        // Apaga da instância do Zend Auth a identificação no sistema.
        Zend_Auth::getInstance()->clearIdentity();

        // Redireciona para a página inicial do site.
        $this->_redirect('login');
    }

}
