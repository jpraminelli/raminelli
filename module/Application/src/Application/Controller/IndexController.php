<?php

namespace Application\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdpter;
use Zend\Db\Sql\Sql;
use Application\Form\Contato;

class IndexController extends ActionController {

    public function indexAction() {

        $post = $this->getTable('Application\Model\Post');
        $sql = $post->getSql();
        $select = $sql->select();

        $paginatorAdapter = new PaginatorDbSelectAdpter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));

        return new ViewModel(array(
            'posts' => $paginator,
            'linkAtual' => 'home'
        ));
    }
    public function contatoAction() {

        $adapter = $this->getServiceLocator()->get('DbAdapter');

        $sql = new Sql($adapter);
        $select = $sql->select()
                ->from('posts')
                ->order('post_date DESC');
       
        $paginatorAdapter = new PaginatorDbSelectAdpter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage(5);
        
        //form
        $form = new Contato;
                
        
        return new ViewModel(array(
            'demaisPosts' => $paginator,
            'linkAtual' => 'contato',
            'form' => $form
        ));
    }

    public function detalheAction() {

        $id_route = $this->params()->fromRoute('id', 0);
        $partes = explode('-', $id_route);
        $id = (int) end($partes);
        $post = $this->getTable('Application\Model\Post')->select(array('id' => $id));
        $row = $post->current();


        if ($row === false) {
            return $this->redirect()->toRoute('home');
        }

        $adapter = $this->getServiceLocator()->get('DbAdapter');

        $sql = new Sql($adapter);
        $select = $sql->select()
                ->from('posts')
                ->where("id <> {$id}")
                ->order('post_date DESC');
       
        $paginatorAdapter = new PaginatorDbSelectAdpter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage(5);
        
        return new ViewModel(array(
            'post' => ($row) ? $row->toArray() : array(),
            'demaisPosts' => $paginator,
            'linkAtual' => 'home'
        ));
    }

}
