<?php

namespace App\ApiMiddleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Tuupola\Middleware\ServerTiming\CallableDelegate;

class ApiAuditMiddleware implements MiddlewareInterface
{
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		return $this->process($request, new CallableDelegate($next, $response));
	}

	public function process(ServerRequestInterface $request, DelegateInterface $delegate)
	{
		$logger = $this->container->get("logger");
		$path = $request->getUri()->getPath();

//		$logger->info('Calling an existing API endpoint', [
//			'ip'            => $request->getAttribute('ip_address'),
//			'path'          => $path,
//			'authorization' => $request->getHeader('Authorization'),
//			'token'         => explode(' ', $request->getHeader('Authorization')[ 0 ])[ 1 ],
//		]);

		$response = $delegate->process($request);
		$uri = $request->getUri()->getPath();
		$statusCode = $response->getStatusCode();

		switch ($statusCode) {
			case 500:
				$logger->critical('Internal server error 500', [
					'ip'     => $request->getAttribute('ip_address'),
					'uri'    => $uri,
					'status' => $statusCode,
				]);
				break;
			case 404:
				$logger->warning('Calling a non-existing API endpoint', [
					'ip'     => $request->getAttribute('ip_address'),
					'uri'    => $uri,
					'status' => $statusCode,
				]);
				break;
			default:
				$logger->info('Calling an existing API endpoint', [
					'ip'     => $request->getAttribute('ip_address'),
					'uri'    => $uri,
					'status' => $statusCode,
				]);
				break;
		}

		return $response;
	}
}



