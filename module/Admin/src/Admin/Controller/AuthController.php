<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Form\Login;

class AuthController extends ActionController{
    public function indexAction() {
        parent::indexAction();
        $form = new Login();
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    public function loginAction(){
        $request = $this->getRequest();
        if(!$request->isPost()){
            //todo acesso invalido
            die('acesso invalido');
        }
        
        $data = $request->getPost();
        $service = $this->getService('Admin\Service\Auth');
        $auth = $service->authenticate(array(
            'username' => $data['username'],
            'password' => $data['password']
        ));
        return $this->redirect()->toUrl('/');
    }
    
    public function logoutAction(){
        $service = $this->getService('Admin\Service\Auth');
        $auth = $service->logout();
        return $this->redirect()->toUrl('/');
                
    }
}

