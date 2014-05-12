<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class Comentario extends Form {

    public function __construct($id) {
        parent::__construct('comentario');

        $this->setAttribute('method', 'post');
        
         $this->add(array(
                'type' => 'Hidden',
                'name' => 'post_id',
                'attributes' => array(
                        'value' => $id
                )
            )
        );

        $this->add(array(
            'name' => 'name',
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
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'span8',
                'rows' => 5
            ),
            'options' => array(
                'label' => 'Comentário:'
            ),
        ));

        $captchaImage = new CaptchaImage(  array(
                'font' => realpath('.') . '/public/fonts/code_bold.otf',
                'dotNoiseLevel' => 30,
                'lineNoiseLevel' => 2,
                'wordlen' => 4,
                'fsize' => 30
            )
        );
        $captchaImage->setImgDir(realpath('.').'/public/captcha');
        $captchaImage->setImgUrl(WWWROOT.'captcha');
        
 
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
