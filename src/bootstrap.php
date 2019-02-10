<?php

use App\ServiceProviders\MonologAuditLogServiceProvider;
use App\ServiceProviders\MonologServiceProvider;
use App\Token;
use App\Validators\PortalCreationValidator;
use Micheh\Cache\CacheUtil;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// 		Bootstrap and configuration
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

// Set the project's base
if ( ! defined(APP_ROOT)) {
	$spl = new SplFileInfo(__DIR__ . '/..');
	define(APP_ROOT, $spl->getRealPath());
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

//$container[ "notFoundHandler" ] = function ($container) {
	//return new Slim\Handlers\NotFound;
//};

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// 		Service providers
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

// -------------------------------------------------------
// 			    Monolog Service Provider
// -------------------------------------------------------
$container->register(new MonologServiceProvider());
// $container->register(new MonologAuditLogServiceProvider());
// $container->register(new WhoopsServiceProvider());

//$container[ 'audit_log' ] = function ($container) {
//    $settings = $container->get('settings');
//    $loggerName = $settings->get('audit_log')[ 'name' ];
//    $loggerPath = $settings->get('audit_log')[ 'audit_path' ];
//    $audit_log = new Logger($loggerName);
//    # PSR 3 log message formatting for all handlers
//    $audit_log->pushProcessor(new PsrLogMessageProcessor());
//
//    $filename = sprintf($loggerPath . "%s", $audit_log->getName());
//    $handler = new RotatingFileHandler($filename, 24, Logger::INFO, true, 0777, true);
//
//    $handler->setFilenameFormat('{filename}-{date}.log', 'Y-m-d');
//
//    $format = "[%datetime%][%channel%][%level_name%][%extra.file%][%extra.line%][%extra.ip%][M:%message%][ID:%extra.uid%][C:%context%][E:%extra%]\n\n";
//    $handler->pushProcessor(new UidProcessor(24));
//    $handler->pushProcessor(new MemoryUsageProcessor());
//    $handler->pushProcessor(new MemoryPeakUsageProcessor());
//    $handler->pushProcessor(new ProcessIdProcessor());
//    $handler->pushProcessor(new WebProcessor());
//    $handler->pushProcessor(new IntrospectionProcessor());
//    $handler->setFormatter(new LineFormatter($format, 'H:i:s'));
//    $audit_log->pushHandler(new BufferHandler($handler));
//
//    return $audit_log;
//};

// -------------------------------------------------------
// To completely disable Slim’s error handling,
// simply remove the error handler from the container:
// -------------------------------------------------------
//unset($app->getContainer()['errorHandler']);
//unset($app->getContainer()['phpErrorHandler']);


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
	return new \App\Repository\PortalRepository($container[ 'logger' ], $container[ 'em' ]);
};
$container[ 'userRepository' ] = function ($container) {
	return new \App\Repository\UserRepository($container[ 'logger' ], $container[ 'em' ]);
};
$container[ 'tokenRepository' ] = function ($container) {
    return new \App\Repository\TokenRepository($container[ 'logger' ], $container[ 'em' ]);
};
// -------------------------------------------------------
// 			    Endpoint Service Provider wire-up
// -------------------------------------------------------
$container[ 'App\Endpoints\PortalEndpoint' ] = function ($container) {
	return new App\Endpoints\PortalEndpoint($container[ 'portalRepository' ], $container[ 'userRepository' ], $container[ 'cache' ], $container[ 'portalCreationValidator' ], $container[ 'portalGetValidator' ], $container[ 'token' ], $container[ 'Stopwatch' ]);
};
$container[ 'App\Endpoints\UserEndpoint' ] = function ($container) {
	return new App\Endpoints\UserEndpoint($container[ 'portalRepository' ], $container[ 'userRepository' ], $container[ 'cache' ], $container[ 'portalCreationValidator' ], $container[ 'portalGetValidator' ], $container[ 'token' ], $container[ 'Stopwatch' ]);
};
$container[ 'App\Endpoints\LoginEndpoint' ] = function ($container) {
    return new App\Endpoints\LoginEndpoint($container[ 'loginRepository' ], $container[ 'Stopwatch' ]);
};
$container[ 'App\Endpoints\TokenEndpoint' ] = function ($container) {
    return new App\Endpoints\TokenEndpoint($container[ 'portalRepository' ], $container[ 'userRepository' ], $container[ 'cache' ], $container[ 'portalCreationValidator' ], $container[ 'portalGetValidator' ], $container[ 'token' ], $container[ 'Stopwatch' ]);
};

// -------------------------------------------------------
// 			   DatabaseSeeder Service Provider
// -------------------------------------------------------
$container[ 'DatabaseSeeder' ] = function ($container) {
	return new \App\Helpers\DatabaseSeedHelper($container);
};

// -------------------------------------------------------
// 			   HashingHelper Service Provider
// -------------------------------------------------------
$container[ 'HashingHelper' ] = function ($container) {
    return new \App\Helpers\HashingHelper($container);
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
// 			   Respect Validation Service Provider
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