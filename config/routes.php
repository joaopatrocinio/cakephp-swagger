<?php

use Cake\Core\Configure;
use Cake\Routing\Router;

/*
 * Connect routes using configuration file, otherwise use defaults:
 *
 * - UI, defaults to /swagger
 * - docs, defaults to /swagger/docs
 * - per library document, defaults to /swagger/docs/:id
 */
$routes->plugin('Cstaf/Swagger', [
    'path' => '/',
], function (\Cake\Routing\RouteBuilder $routes) {

    // UI route
    if (Configure::read('Swagger.ui.route')) {
        $routes->connect(
            Configure::read('Swagger.ui.route'),
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Ui', 'action' => 'index']
        );
    } else {
        $routes->connect(
            '/cstaf/swagger/',
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Ui', 'action' => 'index']
        );
    }

    // Documents route
    if (Configure::read('Swagger.docs.route')) {
        $routes->connect(
            Configure::read('Swagger.docs.route'),
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Docs', 'action' => 'index']
        );

        $routes->connect(
            Configure::read('Swagger.docs.route') . '{id}',
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Docs', 'action' => 'index']
        )
            ->setPatterns(['id' => '\w+'])
            ->setPass(['id']);
    } else {
        $routes->connect(
            '/cstaf/swagger/docs',
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Docs', 'action' => 'index']
        );

        $routes->connect(
            '/cstaf/swagger/docs/{id}',
            ['plugin' => 'Cstaf/Swagger', 'controller' => 'Docs', 'action' => 'index']
        )
            ->setPatterns(['id' => '\w+'])
            ->setPass(['id']);
    }
});
