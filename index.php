<?php
/**
 * =============================================================================
 * CONSTANT Framework — Front controller (the single entry point)
 * =============================================================================
 *
 * Thanks to .htaccess, EVERY request to the app arrives here. This file has
 * exactly two jobs:
 *   1. boot the framework (load config, core, models),
 *   2. define the routes and hand the request to the Router.
 *
 * Notice what is NOT here anymore: database credentials. Those live only in
 * config/config.php now. This file stays about routing, and nothing else.
 */

require 'core/bootstrap.php';

/**
 * The routes table maps a URL to a "Controller@method".
 * Add a page by adding a line here and a matching method on the controller.
 */
$routes = [
    ''       => 'PersonController@index',   // the list / home page
    'create' => 'PersonController@store',   // handle the "Add" modal form
    'update' => 'PersonController@update',  // handle the "Edit" modal form
    'delete' => 'PersonController@destroy', // handle the "Delete" confirmation
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');
