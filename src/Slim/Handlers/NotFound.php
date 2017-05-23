<?php
namespace Slim\Handlers;

use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class NotFound extends \Slim\Handlers\Error
{
	public function __invoke(Request $request, Response $response)
	{
		$problem = new ApiProblem(
			"Not found",
			"http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html"
		);
		$problem->setStatus(404);
		$body = $problem->asJson(true);

		return $response
			->withStatus(404)
			->withHeader("Content-type", "application/problem+json")
			->write($body);
	}
}