<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
 
class FormatarData extends AbstractHelper
{
    public function __invoke($data)
    {
       $timestamp = strtotime($data);
       return date('d/m/Y', $timestamp); 
        
    }
}

