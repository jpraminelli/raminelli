<?php

namespace Application\Form;

use Zend\Form\Form;

class Contato extends Form {

    public function __construct() {
        parent::__construct('contato');

        $this->setAttribute('method', 'post');
        $this->setAttribute('action', WWWROOT.'contato');

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'span8',
            ),
            'options' => array(
                'label' => 'Seu nome:',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'span8',
            ),
            'options' => array(
                'label' => 'Seu email:',
            ),
        ));

        $this->add(array(
            'name' => 'texto',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'span8',
                'rows' => 5
            ),
            'options' => array(
                'label' => 'Texto:'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Enviar',
                'id' => 'submitbutton'
            ),
        ));
    }

}
