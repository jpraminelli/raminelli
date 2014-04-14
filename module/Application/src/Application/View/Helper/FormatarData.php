<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
 
class FormatarData extends AbstractHelper
{
    public function __invoke($data)
    {
       date_default_timezone_set('UTC');
       $timestamp = strtotime($data);
       return date('d/m/Y', $timestamp); 
        
    }
}

