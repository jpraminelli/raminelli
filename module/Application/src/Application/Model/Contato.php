<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;

class Contato extends Entity {

    protected $tableName = 'contato';
    protected $id;
    protected $nome;
    protected $email;
    protected $texti;
    protected $data;

    public function getInputFilter() {
        parent::getInputFilter();

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'nome',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
                            array('name' => 'StripTags'),
                        ),
                        'validators' => array(array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 3,
                                    'max' => 150,
                                ),
                            )),
            )));


            $inputFilter->add($factory->createInput(array(
                        'name' => 'email',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
                            array('name' => 'StripTags'),
                        ),
                        'validators' => array(array(
                                'name' => 'EmailAddress',
                         ),
                            ),
            )));


            $inputFilter->add($factory->createInput(array(
                        'name' => 'texto',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StringTrim'),
                            array('name' => 'StripTags'),
                        ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
