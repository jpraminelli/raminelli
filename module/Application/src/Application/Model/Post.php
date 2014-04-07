<?php
namespace Application\Model;
use Zend\InputFilter\Factory as inputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;

class Post extends Entity{
    protected $tableName = 'posts';
    protected $id;
    protected $title;
    protected $description;
    protected $post_date;
    
    public function getInputFilter() {
        
        parent::getInputFilter();
    }
}

