<?php

// -----------------------------------------------------------------------------
// DotEnv section
// -----------------------------------------------------------------------------
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__ . '/environments/');
$dotenv->load();

return [
	'settings' => [
		'url'                 => 'http://localhost',
        'timezone' => 'Europe\Zagreb',
		'hash'                => [
			'algo' => PASSWORD_BCRYPT,
			'cost' => 10],
		'mail'                => [
			'secret' => 'key-8hcw3e4i8d35gmlas49a9lzt8zvojla3',
			'domain' => 'sandbox06c2d66e2feb448aaccf19ea3458a838.mailgun.org',
			'from'   => 'bruno.bozic@gmail.com',
		],
		'whoops'              => [
			// Enable whoops
			'debug'         => true,
			// Support click to open editor
			'whoops.editor' => 'sublime'
		],
		// If you put it in production, change it to false
		'displayErrorDetails' => true, // set to false in production
		'autoloading_paths'   => [
			'service_config_dir'        => APP_ROOT . '/Configuration/services/',
			'mvc_route_config_dir'      => APP_ROOT . '/Configuration/MvcRoutes/',
			'api_route_config_dir'      => APP_ROOT . '/Configuration/ApiRoutes/',
			'mvc_middleware_config_dir' => APP_ROOT . '/Configuration/MvcMiddleware/',
			'api_middleware_config_dir' => APP_ROOT . '/Configuration/ApiMiddleware/',
			'autoloads_config_dir'      => APP_ROOT . '/Configuration/autoloads/',
			'mvc_validator_config_dir'  => APP_ROOT . '/Configuration/validators/',
			'repository_config_dir'     => APP_ROOT . '/Configuration/Repositories/',
		],
		// Renderer settings: where are the templates???
		'renderer'            => [
			'template_path' => APP_ROOT . '/src/templates/',
		],
		// Monolog settings
		'logger'              => [
            'timezone' => 'Europe\Zagreb',
			'log_name' => 'app-inspector-log',
			'log_path' => APP_ROOT . '/src/storage/logs/'],
		// Monolog settings
		'tracer'              => [
            'timezone' => 'Europe\Zagreb',
			'name'        => 'app-inspector-tracer',
			'tracer_path' => APP_ROOT . '/src/storage/logs/',
		],
		// Monolog settings
		'audit_log'           => [
            'timezone' => 'Europe\Zagreb',
			'name'       => 'app-inspector-auditor',
			'audit_path' => APP_ROOT . '/src/storage/logs/',
		],
		// View settings
		'view'                => [
			'template_path' => APP_ROOT . '/src/templates/',
			'twig'          => [
				'cache'       => APP_ROOT . '/src/storage/cache/twig',
				'debug'       => true,
				'auto_reload' => true,
			],
		],
		// Doctrine settings
		'doctrine'            => [
			'meta'               => [
				'entity_path'           => [
					'src/App/Entities'
				],
				'auto_generate_proxies' => true,
				'proxy_dir'             => APP_ROOT . '/src/storage/cache/proxies',
				'cache'                 => null,
			],
			'connection'         => [
				'driver'   => 'pdo_pgsql',
				'host'     => getenv('DB_HOST'),
				'dbname'   => getenv('DB_NAME'),
				'user'     => getenv('DB_USER'),
				'password' => getenv('DB_PASS'),
			],
			'service_config_dir' => __DIR__ . '/Configuration/services'
		],
	],
];