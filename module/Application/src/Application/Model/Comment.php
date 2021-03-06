<?php
namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;

class Comment extends Entity{
    
    protected $tableName = 'comments';
    protected $id;
    protected $post_id;
    protected $description;
    protected $name;
    protected $email;
    protected $webpage;
    protected $comment_date;
    
    public function getInputFilter() {
        parent::getInputFilter();
        
          if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'post_id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'description',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
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
                )),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ),
                )),
            )));
           
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'comment_date',
                'required' => false,
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

