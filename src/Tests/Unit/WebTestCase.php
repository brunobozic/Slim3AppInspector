<?php
namespace Tests\Unit;

use App\Helpers\SlimInstance;

class WebTestCase extends \PHPUnit_Framework_TestCase
{
	protected $app;

	protected $client;

	// Run for each unit test to setup our slim app environment
	/**
	 *
	 */
	public function setup()
	{
		// Establish a local reference to the Slim app object
		// Ensure no cache Router
		$this->app = $this->getSlimInstance();
		// $this->client = new WebTestClient($this->app);
	}

	// Return the configured Slim App object
	public function getSlimInstance()
	{
		return SlimInstance::getInstance();
	}
}