<?php

namespace Admin;

use \Zend\View\Helper\FlashMessenger;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e) {
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao módulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
    }

   /**
     * Verifica se precisa fazer a autorização do acesso
     * @param  MvcEvent $event Evento
     * @return boolean
     */
    public function mvcPreDispatch($event)
    {
        $this->_flashMessenger = new FlashMessenger();
        
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');

        $authService = $di->get('Admin\Service\Auth');
        if (! $authService->authorize($moduleName, $controllerName, $actionName)) {
           
            $this->_flashMessenger->addMessage('Acesso restrito.');
            header('location: '.WWWROOT.'admin/auth/index');
            die;
        }
        
        return true;
    }

}
