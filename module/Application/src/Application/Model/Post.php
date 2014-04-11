<?php
namespace Application\Model;
use Zend\InputFilter\Factory as inputFactory;
use Zend\InputFilter\InputFilter;
//use Zend\InputFilter\InputFilterAwareInterface;
//use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;

class Post extends Entity{
    protected $tableName = 'posts';
    protected $id;
    protected $title;
    protected $description;
    protected $post_date;
    
    public function getInputFilter() {
        
        parent::getInputFilter();
        
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
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
                'name' => 'description',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'post_date',
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

