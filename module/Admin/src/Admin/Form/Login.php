<?php

namespace Admin\Form;

use Zend\Form\Form;

class Login extends Forms {
    public function __construct() {
        parent::__construct('login');
        $this->setAttribute('method','post');
        $this->setAttribute('action','/admin/auth/login');
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Usuário'
            )
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Senha'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'id' => 'submitbutton'
            ),
        ));
    }
}

