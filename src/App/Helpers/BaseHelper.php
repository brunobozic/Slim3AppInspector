<?php

/**
 * Created by PhpStorm.
 * User: brunobozic
 * Date: 09.02.17.
 * Time: 17:08
 */
namespace App\Helpers;

use Slim\Container;

abstract class BaseHelper
{
	protected $logger;
	protected $container;

	public function __construct(Container $c)
	{
		$this->logger = $c->get('logger');
		$this->container = $c;
	}
}