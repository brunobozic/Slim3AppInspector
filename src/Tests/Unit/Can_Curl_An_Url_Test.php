<?php
namespace Tests\Unit;

use App\Helpers\CurlHelper;
use Slim\App;
use Tests\SlimInstance;

class CurlAnUrlTest extends \PHPUnit_Framework_TestCase
{
	protected $app;
	protected $container;
	protected $client;

	// Run for each unit test to setup our slim app environment
	public function setup()
	{
		$defaultSettings = array(
			'version'             => '0.0.0',
			'debug'               => false,
			'mode'                => 'testing',
			'routerCacheFile'     => false,
			'url'                 => 'http://localhost',
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
				'name' => 'pac-healthcheck',
				'path' => APP_ROOT . '/src/storage/logs/'],
			// Monolog settings
			'tracer'              => [
				'name'        => 'pac-healthcheck-tracer',
				'tracer_path' => APP_ROOT . '/src/storage/logs/',
			],
			// Monolog settings
			'audit_log'           => [
				'name'       => 'pac-healthcheck-auditor',
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
					'driver'   => 'pdo_mysql',
					'host'     => '127.0.0.1',
					'dbname'   => 'application_inspector',
					'user'     => "root",
					'password' => "root",
				],
				'service_config_dir' => __DIR__ . '/Configuration/services']
		);

		$this->app = new App($defaultSettings);
		$this->container = $this->app->getContainer();
	}

	public function test_curl_reads_response_from_web_page()
	{
		$targetUrl = 'https://inflight.pacwisp.net/wisp-ber/backend/version';

		$this->assertNotEmpty($targetUrl);

		$myCurlHelper = new CurlHelper($this->container);

		$response = $myCurlHelper->curl_get($targetUrl);

		var_dump($response);

		$this->assertNotEmpty($response);
	}
}