<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

// Import declarations
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;

$baseUrl = '/localhost/cricket/web/';
$debug = true;

// Start Silex
$app = new Silex\Application();
$app['debug'] = $debug;

// Start Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views/');
$twig = new Twig_Environment($loader, array(
	'cache' => __DIR__ . '/../cache/compilation_cache',
	'debug' => $debug,
));

// Register Service Providers
$app->register(new Silex\Provider\SessionServiceProvider());

$app->get('', function() use ($app, $twig) {
	$loggedIn = $app['session']->get('loggedIn');
	if (! $loggedIn) {
		return $app->redirect('login');
	}
	$template = $twig->loadTemplate('league.html');
	return $template->render(array('errors' => null));
});

$app->post('login', function(Request $request) use ($app) {
	$loggedIn = false;
	if (1 == 1) {
		$loggedIn = true;
	}
	$app['session']->set('loggedIn', $loggedIn);
	return $app->redirect('/cricket/web/');
});

$app->get('login', function() use ($twig) {
	$template = $twig->loadTemplate('login.html');
	return $template->render(array('errors' => null));
});

$app->get('/summary', function(Request $request) {
	return 'Summary';
});

$app->error(function (\Exception $exception, $code) {
	switch ((integer) $code) {
		
		
		default:
			return print_r($exception, true);
			break;
	}
});

// Run Silex
$app->run();
