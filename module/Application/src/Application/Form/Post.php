<?php

namespace Application\Form;

use Zend\Form\Form;

class Post extends Form {

    public function __construct() {
        parent::__construct('post');

        $this->setAttribute('method', 'post');
        $this->setAttribute('action', WWWROOT.'admin/index/index/save');

        $this->add(array(
                'type' => 'Hidden',
                'name' => 'id',
                'attributes' => array(
                        'value' => ''
                )
            )
        );

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'span8',
            ),
            'options' => array(
                'label' => 'Título',
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'span8',
                'rows' => 5
            ),
            'options' => array(
                'label' => 'Texto do post'
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
