<?php
require 'core/bootstrap.php';

$routes = [
	'credit/view' => 'CreditController@refresh',
	'credit/create' => 'CreditController@create',
	'credit/update' => 'CreditController@update',
	'credit/sync' => 'CreditController@sync',
];

$db = [
	'name'     => 'kreditfirma',
	'username' => 'root',
	'password' => '',
];

$router = new Router($routes);
$router->run($_GET['url'] ?? '');