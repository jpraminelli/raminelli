<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/[page/:page]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                        'module'     => 'application',
                    ),
                ),
            ),
            'contato' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/contato',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'contato',
                        'module'     => 'application',
                    ),
                ),
            ),
            'busca' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/busca[:busca]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'busca',
                        'module'     => 'application',
                    ),
                ),
            ),
            'admin/auth/index' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => 'admin/auth/index',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Auth',
                        'action'     => 'index',
                        'module'     => 'admin',
                    ),
                ),
            ),
            'detalhe' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/detalhe[/:id][/:page]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'detalhe',
                        'module'     => 'Application',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        'controller'    => 'Index',
                        'action'        => 'index',
                        '__NAMESPACE__' => 'Application\Controller',
                        'module'     => 'application'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div class="alert alert-error">',
            'message_close_string'     => '</div>',
        )
    ),

);
