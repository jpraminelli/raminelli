<?php

namespace Application\Controller;

use Application\Form\Comentario;
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

        $request = $this->getRequest();
        if ($request->isPost()) {

            $contato = new \Application\Model\Contato();
            $form->setInputFilter($contato->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                unset($data['submit']);
                unset($data['captcha']);

                $data['data'] = date('Y-m-d H:i:s');
                $contato->setData($data);

                $saved = $this->getTable('Application\Model\Contato')->save($contato);
                if ($saved) {
                    $this->flashMessenger()->addMessage('Sua mensagem foi enviada com sucesso.');

                    $headers = "MIME-Version: 1.1\r\n";
                    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                    $headers .= "From: jpraminelli@gmail.com\r\n"; // remetente
                    $headers .= "Return-Path: jpraminelli@gmail.com\r\n"; // return-path

                    $corpo = "Formulário Contato\r\n";
                    $corpo .= "Nome: " . $data['nome'] . "\r\n";
                    $corpo .= "E-mail: " . $data['email'] . "\r\n";
                    $corpo .= "Mensagem:" . $data['texto'] . "\r\n";

                    mail("jpraminelli@gmail.com", "Novo contato site", $corpo, $headers);
                }
                return $this->redirect()->toUrl(WWWROOT . 'contato');
            }
        }

        return new ViewModel(array(
            'demaisPosts' => $paginator,
            'linkAtual' => 'contato',
            'form' => $form
        ));
    }
    
    public function buscaAction() {
        
        $adapter = $this->getServiceLocator()->get('DbAdapter');

        $sql = new Sql($adapter);
        $select = $sql->select()
                ->from('posts')
                ->order('post_date DESC');
        
        $paginatorAdapter = new PaginatorDbSelectAdpter($select, $sql);
        $paginator = new Paginator($paginatorAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage(5);
        
        $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
        $busca = strip_tags($busca);
        $busca = trim($busca);
        
        //busca pela string informada
        $sql2 = new Sql($adapter);
        $select2 = $sql2->select()
                ->from('posts')
                ->where(array(
                        new \Zend\Db\Sql\Predicate\PredicateSet(
                        array(
                                new \Zend\Db\Sql\Predicate\Like('description', '%'.$busca.'%'),
                                new \Zend\Db\Sql\Predicate\Like('title', '%'.$busca.'%'),
                            ),
                            \Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_OR
                        ),

        ));

        $statement = $sql2->prepareStatementForSqlObject($select2);
        $results = $statement->execute();      
                

        
        return new ViewModel(array(
            'demaisPosts' => $paginator,
            'linkAtual' => '',
            'buscou' => $busca, //texto que usuario buscou
            'resultado' => $results
           
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
        
        //form
        $form = new Comentario($id);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $comment = new \Application\Model\Comment();
            $form->setInputFilter($comment->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                unset($data['submit']);
                unset($data['captcha']);
                $data['comment_date'] = date('Y-m-d H:i:s');
                $comment->setData($data);
               
                $saved = $this->getTable('Application\Model\Comment')->save($comment);
                if ($saved) { 
                    $this->flashMessenger()->addMessage('Seu Comentário foi enviado e está sob moderação.');

                    $headers = "MIME-Version: 1.1\r\n";
                    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                    $headers .= "From: jpraminelli@gmail.com\r\n"; // remetente
                    $headers .= "Return-Path: jpraminelli@gmail.com\r\n"; // return-path

                    $corpo = "Formulário Comentário\r\n";
                    $corpo .= "Nome: " . $data['name'] . "\r\n";
                    $corpo .= "E-mail: " . $data['email'] . "\r\n";
                    $corpo .= "Comentário:" . $data['description'] . "\r\n";

                    mail("jpraminelli@gmail.com", "Novo comentário site", $corpo, $headers);
                }
                return $this->redirect()->toUrl(WWWROOT .'detalhe/' .$id_route);
            }
        }
        
        //consulta os comentarios ativos
        $sql = new Sql($adapter);
        $select = $sql->select()
                ->from('comments')
                ->where("post_id = {$id}")
                ->where("status IS TRUE");
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();       

        return new ViewModel(array(
            'post' => ($row) ? $row->toArray() : array(),
            'demaisPosts' => $paginator,
            'linkAtual' => 'home',
            'form' => $form,
            'comentarios' => $results
        ));
    }

}
