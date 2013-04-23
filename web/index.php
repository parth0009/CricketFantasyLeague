<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Import declarations
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;

// Start Silex
$app = new Silex\Application();

// Configuration
$app['debug'] = true;

$baseUrl = '/localhost/cricket/web/';
// Service providers


$loggedIn = true;

$app->get('', function() use ($app, $loggedIn) {
	if (! $loggedIn) {
		return $app->redirect('login');
	}
	return 'Dashboard';
});

$app->get('login', function() {
	return 'Login';
});

$app->post('login', function(Request $request) {
	return 'POST login';
	
	$something = 'Hallo';
	$something = $app->escape($something);
	
	return $app->redirect('/');
});

$app->get('/summary', function(Request $request) {
	return 'Summary';
});

$app->error(function (\Exception $exception, $code) {
	switch ((integer) $code) {
		
		
		default:
			return 'Whoops';
			break;
	}
});

// Run Silex
$app->run();
