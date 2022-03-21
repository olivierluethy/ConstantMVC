<?php
require 'core/bootstrap.php';

$routes = [
	'' => 'FrameworkController@refresh',
	'view' => 'FrameworkController@refresh',
	'create' => 'FrameworkController@create',
	'update' => 'FrameworkController@update',
	'sync' => 'FrameworkController@sync',
];

$db = [
	'name'     => 'framework',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');