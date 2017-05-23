<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container;
use Slim\Handlers\Error;

final class ErrorHandler extends Error
{
	protected $logger;
	protected $container;

	public function __construct(Container $container)
	{
		$this->logger = $container->get('logger');
		$this->container = $container;
	}

	public function __invoke(Request $request, Response $response, \Exception $exception)
	{
		//$this->logger->critical("\r\n" . " File: " . $exception->getFile() . " Code: " . "\r\n" . $exception->getCode() . " Line: " . "\r\n" . $exception->getLine() . " Exception: " . "\r\n" . $exception->getMessage());
		$this->logger->critical($exception);
		return parent::__invoke($request, $response, $exception);
	}
}