<?php

use App\ServiceProviders\MonologServiceProvider;
use App\Token;
use App\Validators\PortalCreationValidator;
use Micheh\Cache\CacheUtil;

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// 		Bootstrap and configuration
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

// Set the project's base
if ( ! defined('APP_ROOT')) {
	$spl = new SplFileInfo(__DIR__ . '/..');
	define('APP_ROOT', $spl->getRealPath());
}

// Set the vendor modules
$loader = require_once APP_ROOT . '/vendor/autoload.php';

// Fetch settings
$settings = require APP_ROOT . '/configuration/settings.php';

$app = new \Slim\App($settings);

// 		DIC configuration
$container = $app->getContainer();
require __DIR__ . "/App/Middleware/Middleware.php";
require __DIR__ . "/App/Routes/Routes.php";
require __DIR__ . "/App/Token.php";

//$container[ 'errorHandler' ] = function ($container) {
//	return new \App\Handlers\ErrorHandler($container);
//};

$container[ "errorHandler" ] = function ($container) {
	return new Slim\Handlers\ApiError($container[ "logger" ]);
};

$container[ "phpErrorHandler" ] = function ($container) {
	return $container[ "errorHandler" ];
};

$container[ "notFoundHandler" ] = function ($container) {
	return new Slim\Handlers\NotFound;
};

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// 		Service providers
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

// -------------------------------------------------------
// 			    Monolog Service Provider
// -------------------------------------------------------
$container->register(new MonologServiceProvider());
//$container->register(new WhoopsServiceProvider());

// -------------------------------------------------------
// To completely disable Slim’s error handling,
// simply remove the error handler from the container:
// -------------------------------------------------------
//unset($app->getContainer()['errorHandler']);
//unset($app->getContainer()['phpErrorHandler']);

$container[ 'tracer' ] = function ($container) {

	$settings = $container->get('settings');
	$logger = new \Monolog\Logger($settings[ 'tracer' ][ 'name' ]);
	$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
	$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings[ 'tracer' ][ 'tracer_path' ], \Monolog\Logger::DEBUG));

	return $logger;
};

$container[ 'audit_log' ] = function ($container) {

	$settings = $container->get('settings');
	$logger = new \Monolog\Logger($settings[ 'audit_log' ][ 'name' ]);
	$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
	$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings[ 'audit_log' ][ 'audit_path' ], \Monolog\Logger::DEBUG));

	return $logger;
};

// -------------------------------------------------------
// 			    Doctrine Service Provider
// -------------------------------------------------------
$container[ 'em' ] = function ($container) {
	$settings = $container->get('settings');
	$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
		$settings[ 'doctrine' ][ 'meta' ][ 'entity_path' ],
		$settings[ 'doctrine' ][ 'meta' ][ 'auto_generate_proxies' ],
		$settings[ 'doctrine' ][ 'meta' ][ 'proxy_dir' ],
		$settings[ 'doctrine' ][ 'meta' ][ 'cache' ],
		false
	);

	return \Doctrine\ORM\EntityManager::create($settings[ 'doctrine' ][ 'connection' ], $config);
};

// -------------------------------------------------------
// 			    Repository Service Provider wire-up
// -------------------------------------------------------
$container[ 'portalRepository' ] = function ($container) {
	return new \App\Repository\PortalRepository($container[ 'logger' ], $container[ 'tracer' ], $container[ 'em' ]);
};
$container[ 'userRepository' ] = function ($container) {
	return new \App\Repository\UserRepository($container[ 'logger' ], $container[ 'tracer' ], $container[ 'em' ]);
};

// -------------------------------------------------------
// 			    Endpoint Service Provider wire-up
// -------------------------------------------------------
$container[ 'App\Endpoints\PortalEndpoint' ] = function ($container) {
	return new App\Endpoints\PortalEndpoint($container[ 'portalRepository' ], $container[ 'cache' ], $container[ 'portalCreationValidator' ], $container[ 'portalGetValidator' ], $container[ 'token' ], $container[ 'Stopwatch' ]);
};
$container[ 'App\Endpoints\UserEndpoint' ] = function ($container) {
	return new App\Endpoints\UserEndpoint($container[ 'userRepository' ]);
};

// -------------------------------------------------------
// 			   DatabaseSeeder Service Provider
// -------------------------------------------------------
$container[ 'DatabaseSeeder' ] = function ($container) {
	return new \App\Helpers\DatabaseSeedHelper($container);
};

// -------------------------------------------------------
// 			   Ceching Subsytem Service Provider
// -------------------------------------------------------
$container[ "cache" ] = function ($container) {
	return new CacheUtil;
};

// -------------------------------------------------------
// 			   Authorization token helper (hydrator)
// -------------------------------------------------------
$container[ "token" ] = function ($container) {
	return new Token;
};

// -------------------------------------------------------
// 			   Respect validation Service Provider
// -------------------------------------------------------
$container[ 'portalCreationValidator' ] = function () {
	return new PortalCreationValidator();
};
$container[ 'portalGetValidator' ] = function () {
	return new \App\Validators\PortalGetValidator();
};

$container[ 'v' ] = function () {
	return new Respect\Validation\Validator;
};