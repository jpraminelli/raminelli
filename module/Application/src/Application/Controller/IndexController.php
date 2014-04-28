<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdpter;

class IndexController extends ActionController {

    public function indexAction() {

        $post = $this->getTable('Application\Model\Post');
        $sql = $post->getSql();
        $select = $sql->select();

        $paginatorAdapter = new PaginatorDbSelectAdpter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));

        return new ViewModel(array(
            'posts' => $paginator
        ));
    }
    public function detalheAction() {

        $id_route = $this->params()->fromRoute('id', 0);
        $partes = explode('-', $id_route);
        $id = (int) end($partes);
        $post = $this->getTable('Application\Model\Post')->select(array('id' => $id));
        $row = $post->current();
       
       
       if($row === false){ 
          return $this->redirect()->toRoute('home');
          
       }
        

        return new ViewModel(array(
            'post' => ($row) ? $row->toArray() : array(),
        ));
    }
}
    