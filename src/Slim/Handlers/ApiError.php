<?php
namespace Slim\Handlers;

use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Handlers\Error;

final class ApiError extends Error
{
	protected $logger;

    /**
     * ApiError constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public function __invoke(Request $request, Response $response, \Exception $exception)
	{
		$this->logger->critical($exception->getMessage());
		$status = $exception->getCode() ? : 500;
		$problem = new ApiProblem($exception->getMessage(), "about:blank");
		$problem->setStatus($status);
		$body = $problem->asJson(true);

		return $response
			->withStatus($status)
			->withHeader("Content-type", "application/problem+json")
			->write($body);
	}
}