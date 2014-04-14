<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;

class Auth extends Service{
 
    private $dbAdapter;
    
    public function __construct($dbAdapter = null) {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function authenticate($params){
        if(!isset($params['username']) || !isset($params['password'])){
            //todo parametros invalidos
            die('parametros necessarios');
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
        
        if(!$result->isValid()){
            //todo usuario invalido
            die('usuario nao encontrado');
        }
        
        //autentica o usuario
        $session = $this->getServiceManager()->get('Session');
        $session->offsetSet('user', $authAdapter->getResultRowObject());
        
        return true;
        
                
    }
    
    public function logout(){
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();
        return true;
    }
}
