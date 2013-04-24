<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

// Import declarations
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Silex\Provider\SessionServiceProvider as SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider as DoctrineServiceProvider;

$baseUrl = '//localhost/cricket/web/';
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
$twigParameters = array('baseUrl' => $baseUrl);

// Register Service Providers
$app->register(new SessionServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
		'db.options' => array(
				'driver' =>'pdo_sqlite',
				'path'     => __DIR__. '/../cricket.sqlite',
		),
));

$app->get('', function() use ($app, $twig, $twigParameters) {
	$loggedIn = $app['session']->get('loggedIn');
	$user = $app['session']->get('user');
	if (! $loggedIn) {
		return $app->redirect('login');
	}
	$template = $twig->loadTemplate('league.html');
	return $template->render($twigParameters);
});

$app->post('login', function(Request $request) use ($app) {
	$loggedIn = false;
	$login = $request->get('login');
	$password = $request->get('password');
	
	$sql = "SELECT * FROM users WHERE login = ?"/* . " AND password = ?"*/;
	$user = $app['db']->fetchAssoc($sql, array((string) $login));
	$userId = $user['id'];
	$app['session']->set('user', $user);
	//var_dump($user);exit();
	if ($user) {
		$loggedIn = true;
	}
	$app['session']->set('loggedIn', $loggedIn);
	return $app->redirect('/cricket/web/');
});

$app->get('login', function() use ($twig, $twigParameters) {
	$template = $twig->loadTemplate('login.html');
	return $template->render($twigParameters);
});

$app->get('logout', function() use ($app) {
	$app['session']->set('user', null);
	$app['session']->set('loggedIn', null);
	return $app->redirect('/cricket/web/');
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
