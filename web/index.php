<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;

$app = new Silex\Application();

$app['debug'] = true;

$app->get('/', function(Request $response, Response $response) {
	return 'Hello world';
});

$app->get('/login', function(Request $response, Response $response) {
	return 'Login';
});

$app->post('/login', function(Request $response, Response $response) {
	return 'POST login';
});

$app->run();
