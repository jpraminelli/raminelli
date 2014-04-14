<?php
namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;

class User extends Entity{
    
    protected $tableName = 'users';
    protected $id;
    protected $username;
    protected $password;
    protected $name;
    protected $valid;
    protected $role;
    
    public function getInputFilter() {
        parent::getInputFilter();
        
        if(!$this->inputFilter){
            
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required'  => true,
                'filters' => array(
                    array('name' => 'Int')
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'username',
                'required'  => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => '1',
                        'max' => 50
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'password',
                'required'  => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'required'  => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'valid',
                'required'  => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'role',
                'required'  => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => '1',
                        'max' => 20
                    ),
                ),
            )));

            $this->inputFilter =$inputFilter;
            
        }
        
        return $this->inputFilter;
    }
    
    
    
}