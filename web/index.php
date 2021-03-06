<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

// Import declarations
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Silex\Provider\SessionServiceProvider as SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider as DoctrineServiceProvider;
use \Doctrine\Common\Cache\ApcCache;
use \Doctrine\Common\Cache\ArrayCache;
use \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

$baseUrl = '//localhost/cricket/web'; // Without trailing slash
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
		'path'     => __DIR__. '/../data/cricket.sqlite',
	),
));

// Register Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
		// Doctrine DBAL settings goes here
));

// Register Doctrine ORM
$app->register(new Nutwerk\Provider\DoctrineORMServiceProvider(), array(
		'db.orm.proxies_dir'           => __DIR__ . '/../cache/doctrine/proxy',
		'db.orm.proxies_namespace'     => 'DoctrineProxy',
		'db.orm.cache'                 =>
		!$app['debug'] && extension_loaded('apc') ? new ApcCache() : new ArrayCache(),
		'db.orm.auto_generate_proxies' => true,
		'db.orm.entities'              => array(array(
				'type'      => 'annotation',       // entity definition
				'path'      => __DIR__ . '/src',   // path to your entity classes
				'namespace' => 'Model\Entity', // your classes namespace
		)),
));
$entityManager = $app['db.orm.em'];

// Define user roles
define('ROLE_MEMBER', 'member');
define('ROLE_ADMIN', 'admin');

$users = array(
	// raw password is foo
	'admin' => array(ROLE_ADMIN,
		'5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
	'member' => array(ROLE_MEMBER,
		'5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg=='),
);

// Define user restrictions
$app['security.firewalls'] = array(
	'unsecured' => array(
		'anonymous' => true,
	),
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

/*
 * Temporary user instantiation until Doctrine user provider is setup with security provider
 */
try {
	$user = $entityManager->getRepository('Model\Entity\User')->findOneBy(array('login' => 'magickatt'));
} catch (Exception $e) {
	var_dump($e->getMessage());exit();
}
$twigParameters['user'] = $user;

/*
 * Define routes
 */

// Homepage
$app->get('', function() use ($app, $twig, $entityManager, $twigParameters) {
	
	$template = $twig->loadTemplate('home.html');
	return $template->render($twigParameters);
	
});

// Homepage
$app->get('league', function() use ($app, $user, $twig, $entityManager, $twigParameters) {
	
	if ($user instanceof Model\Entity\User) {
		$team = $user->getTeam();
	}

	$teams = $entityManager->getRepository('Model\Entity\Team')->findAll();
	
	$token = $app['security']->getToken();

	$twigParameters['team'] = $team;
	$twigParameters['teams'] = $teams;
	
	$template = $twig->loadTemplate('league.html');
	return $template->render($twigParameters);
	
});

$app->post('login', function(Request $request) use ($app, $entityManager) {
	
	$loggedIn = false;
	$username = $request->get('_username');
	$password = $request->get('_password');
		
	if (! empty($username) && ! empty($password)) {
		$repository = $entityManager->getRepository('Model\Entity\User');
		try {
			$user = $repository->findOneBy(array('login' => $username));
		} catch (Exception $e) {
			var_dump($e->getMessage());exit();
		}

		if ($user instanceof Model\Entity\User) {
			$password = $password;
			if (strcmp($password, $user->getPassword()) == 0) {
				$loggedIn = true;
			} else {
				var_dump('Password wrong');
			}
		} else {
			var_dump('Username wrong');
		}
	}
	
	if ($loggedIn) {
		
		// https://gist.github.com/simonjodet/3927516
		try {
			$token = new UsernamePasswordToken($user, 'user_firewall', $user->getPassword(), $user->getRoles());
		} catch (Exception $e) {
			var_dump($e->getMessage());exit();
		}
		
		$app['security']->setToken($token);
		return $app->redirect('/cricket/web/');
		
	}
	
	return $app->redirect('/cricket/web/login');
	
});

$app->get('login', function(Request $request) use ($app, $twig, $twigParameters, $entityManager) {
	
	$user = new Model\Entity\User();
	$user->setName('Test User');
	$user->setLogin('something');
	$user->setPassword('something-else');
	$player = new Model\Entity\Player();
	$player->setName('Test Player');
	$player->setLogin('something');
	$player->setPassword('something-else');
	try {
		$entityManager->persist($user);
		$entityManager->persist($player);
		$entityManager->flush();
	} catch (Exception $e) {
		var_dump($e);
	}
	
	$twigParameters['error'] = $app['security.last_error']($request);
	$twigParameters['last_username'] = $app['session']->get('_security.last_username');
	
	$template = $twig->loadTemplate('login.html');
	return $template->render($twigParameters);
	
});

$app->get('/summary', function(Request $request) {
	return 'Summary';
});

$app->get('/team/{id}', function(Request $request, $id) use ($app, $twig, $entityManager, $twigParameters) {
	
	$team = $entityManager->find('Model\Entity\Team', (integer) $id);
	//if (! $team instanceof Model\Entity\Team) {
	//	return 'No';
	//}

    $team = $entityManager->find('Model\Entity\Team', (integer) $id);
    $entries = $entityManager->getRepository('Model\Entity\Entry')->findAll();
	
	$twigParameters['team'] = $team;
    //$twigParameters['entries'] = $entries;
	
	$template = $twig->loadTemplate('team.html');
	return $template->render($twigParameters);
	
});

	$app->get('/team/edit/{id}', function(Request $request, $id) use ($app, $twig, $entityManager, $twigParameters) {
	
		$team = $entityManager->find('Model\Entity\Team', (integer) $id);
		if (! $team instanceof Model\Entity\Team) {
			return 'No';
		}
	
		$team = $entityManager->find('Model\Entity\Team', (integer) $id);
		$entries = $entityManager->getRepository('Model\Entity\Entry')->findAll();
	
		$twigParameters['team'] = $team;
		//$twigParameters['entries'] = $entries;
		
		$twigParameters['game'] = 1;
		
		//$bowlers = $entityManager->findAllBy();
		//$batters = $entityManager->findAll
		//$allstars
		$twigParameters['bowlers'] = $bowlers;
		$twigParameters['batters'] = $batters;
		$twigParameters['allstars'] = $allstars;
	
		$template = $twig->loadTemplate('edit-team.html');
		return $template->render($twigParameters);
	
	});

$app->get('/player/{id}', function(Request $request, $id) use ($app, $twig, $entityManager, $twigParameters) {
	
    $player = $entityManager->find('Model\Entity\User', (integer) $id);
    if (! $player instanceof Model\Entity\User) {
        return 'No';
    }

    //$statistics = Model\Statistic::getStatisticsWithPlayer($player, $entityManager);
    
    /*$q = $entityManager->createQuery("SELECT * FROM Model\Entity\Entry WHERE batter1_id = 4
    UNION
    SELECT * FROM Model\Entity\Entry WHERE batter2_id = 4");
    $entries = $q->getResult();*/
    
    /*$q = $entityManager->createQuery("SELECT * FROM Model\Entity\Entry WHERE batter1_id = 4");
    $entries = $q->getResult();*/
    
    $qb = $entityManager->createQueryBuilder();
    $qb->add('select', 'COUNT(e)')
    	->add('from', 'Model\Entity\Entry e')
    	->add('where', 'e.batter1 = ' . $id . ' OR e.batter2 = ' . $id)
    	->add('orderBy', 'e.id ASC');
    
    $q = $qb->getQuery();
    $result = $q->getResult();
    $countEntries = (integer) array_pop($result[0]);
    //var_dump($countEntries);
    
    
    
    
    $qb = $entityManager->createQueryBuilder();
    $qb->add('select', 'e')
    ->add('from', 'Model\Entity\Entry e')
    ->add('where', 'e.batter1 = ' . $id . ' OR e.batter2 = ' . $id)
    ->add('orderBy', 'e.id ASC');
    
    $q = $qb->getQuery();
    $entries = $q->getResult();
    //var_dump($result);
    
    //exit();

    $twigParameters['player'] = $player;
    $twigParameters['entries'] = $entries;
    $twigParameters['countEntries'] = $countEntries;
    //$twigParameters['statistics'] = $statistics;

    $template = $twig->loadTemplate('player.html');
    return $template->render($twigParameters);
    
});

$app->error(function (\Exception $exception, $code) {
	
	switch ((integer) $code) {
		default:
			var_dump($exception->getMessage());
			exit();
			return print_r($exception, true);
			break;
	}
	
});

// Run Silex
$app->run();