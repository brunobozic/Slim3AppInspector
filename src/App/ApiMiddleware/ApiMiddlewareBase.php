<?php

namespace App\ApiMiddleware {

	class ApiMiddlewareBase
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
