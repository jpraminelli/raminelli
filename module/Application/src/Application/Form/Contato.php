<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Captcha\Image as CaptchaImage;

class Contato extends Form {

    public function __construct() {
        parent::__construct('contato');

        $this->setAttribute('method', 'post');
        $this->setAttribute('action', WWWROOT . 'contato');

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span6',
            ),
            'options' => array(
                'label' => 'Seu nome:',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span6',
            ),
            'options' => array(
                'label' => 'Seu email:',
            ),
        ));

        $this->add(array(
            'name' => 'texto',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'span6',
                'rows' => 5
            ),
            'options' => array(
                'label' => 'Texto:'
            ),
        ));

        $captchaImage = new CaptchaImage(array(
            'font' => realpath('.') . '/public/fonts/code_bold.otf',
            'dotNoiseLevel' => 30,
            'lineNoiseLevel' => 2,
            'wordlen' => 4,
            'fsize' => 30
                )
        );
        $captchaImage->setImgDir(realpath('.') . '/public/captcha');
        $captchaImage->setImgUrl(WWWROOT . 'captcha');


        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Código de segurança:',
                'captcha' => $captchaImage,
            ),
            'attributes' => array(
                'class' => 'span2',
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
