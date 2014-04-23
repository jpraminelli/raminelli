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
        $form = new PostForm();

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
                return $this->redirect()->toUrl(WWWROOT);
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $post = $this->getTable('Application\Model\Post')->get($id);
            $form->bind($post);
            $form->get('submit')->setAttribute('value', 'Edit');
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
        return $this->redirect()->toUrl(WWWROOT);
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

