<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use \Zend\View\Helper\FlashMessenger;




class Auth extends Service {

    private $dbAdapter;
    private $_flashMessenger;
   

    public function __construct($dbAdapter = null) {
        $this->dbAdapter = $dbAdapter;
        $this->_flashMessenger = new FlashMessenger();
        
    }

    public function authenticate($params) {
        if (
                (isset($params['username']) && $params['username'] == '' )  || 
                (isset($params['password']) && $params['password'] == '')
            ){
            //todo parametros invalidos
            $this->_flashMessenger->addMessage('Preencha corretamente o formulário.');
            header('location: '.WWWROOT.'admin/auth/index');
            die;
           
        }

        $senha = md5($params['password']);
        $auth = new AuthenticationService();
        $authAdapter = new AuthAdapter($this->dbAdapter);
        $authAdapter->setTableName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setIdentity($params['username'])
                ->setCredential($senha);
        $result = $auth->authenticate($authAdapter);

        if (!$result->isValid()) {
           //todo parametros invalidos
            $this->_flashMessenger->addMessage('Usuário não encontrado.');
            header('location: '.WWWROOT.'admin/auth/index');
            die;
        }

        //autentica o usuario
        $session = $this->getServiceManager()->get('Session');
        $session->offsetSet('user', $authAdapter->getResultRowObject());

        return true;
    }

    public function logout() {
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();
        return true;
    }

    /**
     * Faz a autorização do usuário para acessar o recurso
     * @param string $moduleName Nome do módulo sendo acessado
     * @param string $controllerName Nome do controller
     * @param string $actionName Nome da ação
     * @return boolean
     */
    public function authorize($moduleName, $controllerName, $actionName) {
        $auth = new AuthenticationService();
        $role = 'visitante';
        if ($auth->hasIdentity()) {
            $session = $this->getServiceManager()->get('Session');
            $user = $session->offsetGet('user');
            $role = $user->role;
        }

        $resource = $controllerName . '.' . $actionName;
        $acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
        if ($acl->isAllowed($role, $resource)) {
            return true;
        }
        return false;
    }

}
