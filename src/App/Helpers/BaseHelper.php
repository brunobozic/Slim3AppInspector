<?php

namespace App\Helpers;

use Slim\Container;

abstract class BaseHelper
{
	protected $logger;
	protected $container;
    protected $settings;

	public function __construct(Container $c)
	{
		$this->logger = $c->get('logger');
		$this->container = $c;
        $this->settings = $c->get('settings');

	}
}