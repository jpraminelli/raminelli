<?php

return array(
    'controllers' => array(//add module controllers
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Auth' => 'Admin\Controller\AuthController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Admin\Controller\Auth',
                        'action' => 'index',
                        'module' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array(//permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
            'admin/index' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/index',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index',
                        'module' => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array(//permite mandar dados pela url
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'module_layout' => array(
        'Admin' => 'layout/layout_admin.phtml'
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
//    'db' => array( //module can have a specific db configuration
//        'driver' => 'PDO_SQLite',
//        'dsn' => 'sqlite:' . __DIR__ .'/../data/skel.db',
//        'driver_options' => array(
//            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
//        )
//    ),
    'service_manager' => array(
        'factories' => array(
            'Session' => function($sm) {
        return new Zend\Session\Container('ZF2napratica');
    },
            'Admin\Service\Auth' => function($sm) {
        $dbAdapter = $sm->get('DbAdapter');
        return new Admin\Service\Auth($dbAdapter);
    }
        ),
    ),
);
