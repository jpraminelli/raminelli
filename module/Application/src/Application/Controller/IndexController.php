<?php


namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController {

    public function indexAction() {
        return new ViewModel(array(
            'posts' => $this->getTable('Application\Model\Post')
                    ->fetchAll()
                    ->toArray()
        ));
    }

}
