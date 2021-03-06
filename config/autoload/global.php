<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=raminelli;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'acl' => array(
        'roles' => array(
            'visitante' => null,
           // 'redator' => 'visitante',
            'admin' => 'visitante'
        ),
        'resources' => array(
            'Application\Controller\Index.index',
            'Admin\Controller\Index.save',
            'Admin\Controller\Index.delete',
            'Admin\Controller\Auth.index',
            'Admin\Controller\Auth.login',
            'Admin\Controller\Auth.logout',
            'Admin\Controller\Index.index',
            'Application\Controller\Index.detalhe',
            'Application\Controller\Index.contato',
            'Application\Controller\Index.busca',
        ),
        'privilege' => array(
            'visitante' => array(
                'allow' => array(
                    'Application\Controller\Index.index',
                    'Admin\Controller\Auth.index',
                    'Admin\Controller\Auth.login',
                    'Admin\Controller\Auth.logout',
                    'Application\Controller\Index.detalhe',
                    'Application\Controller\Index.contato',
                    'Application\Controller\Index.busca',
                )
            ),
//             'redator' => array(
//                 'allow' => array(
//                     'Admin\Controller\Index.save',
//                 )
//             ),
            'admin' => array(
                'allow' => array(
                    'Admin\Controller\Index.delete',
                	'Admin\Controller\Index.save',
                	'Admin\Controller\Index.index',
                )
            ),
        )
    )
);
