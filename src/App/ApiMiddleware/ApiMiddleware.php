<?php

namespace App\ApiMiddleware {

	class BaseApiMiddleware
	{
		protected $container;
		protected $app;
		
		public function __construct($container, $app)
		{
			$this->container = $container;
			$this->app = $app;
		}
	}
}
