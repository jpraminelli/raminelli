<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Application\Model\Post;
use Application\Form\Post as PostForm;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect as PaginatorDbSelectAdpter;

class IndexController extends ActionController {

    public function saveAction() {
        
        //editor de texto
        
        $form = new PostForm();
        $id = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        if ($request->isPost()) { 
            $post = new Post;
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $data = $form->getData();
                unset($data['submit']);
                $data['post_date'] = date('Y-m-d H:i:s');
                $post->setData($data);
                $saved = $this->getTable('Application\Model\Post')->save($post);
                if($data['id'] > 0){ 
                    $this->flashMessenger()->addMessage('Registro alterado com sucesso');
                }
                else{ 
                    $this->flashMessenger()->addMessage('Registro incluido com sucesso'); 
                }
                return $this->redirect()->toUrl(WWWROOT.'admin');
            }
        }
       
        if ($id > 0) {
            $post = $this->getTable('Application\Model\Post')->get($id);
            $form->bind($post);
            $form->get('submit')->setAttribute('value', 'Editar');
        }
        return new ViewModel(
                array('form' => $form)
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \Exception("Código obrigatório");
        }
        $this->getTable('Application\Model\Post')->delete($id);
        $this->flashMessenger()->addMessage('Registro excluído com sucesso');
        return $this->redirect()->toUrl(WWWROOT.'admin');
    }
    
    public function indexAction(){
    	
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

}

