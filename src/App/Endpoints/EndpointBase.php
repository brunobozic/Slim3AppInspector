<?php

namespace App\Endpoints;

class EndpointBase
{
	public static function getVersion($request, $response, $args)
	{
		return $response->write('API Version ' . getenv('API_VERSION'));
	}
}