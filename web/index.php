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
$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
		'db.options' => array(
				'driver' =>'pdo_sqlite',
				'path'     => __DIR__. '/../cricket.sqlite',
		),
));

define('ROLE_MEMBER', 'member');
define('ROLE_ADMIN', 'admin');

$users = array(
	// raw password is foo
	'admin' => array(ROLE_ADMIN,
		'5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
	'member' => array(ROLE_MEMBER,
			'5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
);

$app['security.firewalls'] = array(
	'admin' => array(
		'pattern' => '^/admin/',
        'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
		'logout' => array('logout_path' => '/admin/logout'),
		'http' => true,
		'users' => $users,
	),
	'team' => array(
			'pattern' => '^/team/',
			'form' => array('login_path' => '/login', 'check_path' => '/team/login_check'),
			'logout' => array('logout_path' => '/team/logout'),
			'http' => true,
			'users' => $users,
	),
);

$app->get('', function() use ($app, $twig) {
	￼if (! $app['security']->isGranted(ROLE_MEMBER) || ! $app['security']->isGranted(ROLE_ADMIN)) {
		return $app->redirect('login');
	}
	/*$loggedIn = $app['session']->get('loggedIn');
	if (! $loggedIn) {
		return $app->redirect('login');
	}*/
	$template = $twig->loadTemplate('league.html');
	return $template->render();
});

$app->post('login', function(Request $request) use ($app) {
	$loggedIn = false;
	
	$login = $request->get('login');
	$password = $request->get('password');
	$password = '';
	
	/*$sql = "SELECT * FROM users WHERE login = ? AND password = ?";
	$user = $app['db']->fetchAssoc($sql, array((string) $login));
	$userId = $user['id'];
	
	$loggedIn = $app['session']->set('userId', $userId);
	
	if ($user) {
		$loggedIn = true;
	}
	$app['session']->set('loggedIn', $loggedIn);*/
	return $app->redirect('/cricket/web/');
});

$app->get('login', function() use ($twig, $twigParameters) {
	$template = $twig->loadTemplate('login.html');
	return $template->render($twigParameters);
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

