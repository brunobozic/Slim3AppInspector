<?php
namespace App\Endpoints;

use Exception\ForbiddenException;
use Exception\NotFoundException;
use Exception\PreconditionFailedException;
use Exception\PreconditionRequiredException;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;


class PortalEndpoint extends EndpointBase
{
	public function all($request, $response, $args)
	{
		$this->stopwatch->start("CacheLayer");
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.list"])) {
			throw new ForbiddenException("Token not allowed to list portals", 403);
		}

		/* Use ETag and date from Portal with most recent update. */
		$this->stopwatch->start("Doctrine2-1");
		$first = $this->portalRepository->getLastUpdated();
		$this->stopwatch->stop("Doctrine2-1");

		/* Add Last-Modified and ETag headers to response when at least one Portal exists. */
		if ($first) {
			$response = $this->cache->withEtag($response, $first[ 0 ]->getEtag());
			$response = $this->cache->withLastModified($response, $first[ 0 ]->getModified()->getTimestamp());
		}

		/* If-Modified-Since and If-None-Match request header handling. */
		/* Heads up! Apache removes previously set Last-Modified header */
		/* from 304 Not Modified responses. */
		if ($this->cache->isNotModified($request, $response)) {
			return $response->withStatus(304);
		}
		$this->stopwatch->stop("CacheLayer");


		$this->stopwatch->start("Doctrine2");
		$portals = $this->portalRepository->getAllOrderedByNewest();
		$this->stopwatch->stop("Doctrine2");

		/* Serialize the response data. */
		$this->stopwatch->start("DataTransformation");
		$fractal = new Manager();
		$fractal->setSerializer(new DataArraySerializer);
		$resource = new Collection($portals, new PortalTransformer);
		$data = $fractal->createData($resource)->toArray();
		$this->stopwatch->stop("DataTransformation");

		return $response
			->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}

	public function get($request, $response, $arguments)
	{
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.get"])) {
			throw new ForbiddenException("Token not allowed to list Portal", 403);
		}

		/* Load existing Portal using provided uid */
		$icao = $arguments[ "icao" ];

		$this->stopwatch->start("Validation");
		$isValid = $this->portalGetValidator->assert($icao);
		$this->stopwatch->stop("Validation");

		if ($isValid) {
			$this->stopwatch->start("Doctrine2");
			$portal = $this->portalRepository->get($icao);
			$this->stopwatch->stop("Doctrine2");
		}
		else {
			return $response->withStatus(422)
				->withHeader("Content-Type", "application/json")
				->write(json_encode($this->portalCreationValidator->getErrorsConcat(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}

		if ($portal) {
			/* Add Last-Modified and ETag headers to response. */
			$response = $this->cache->withEtag($response, $portal->getEtag());
			$response = $this->cache->withLastModified($response, $portal->getModified()->getTimestamp());

			/* If-Modified-Since and If-None-Match request header handling. */
			/* Heads up! Apache removes previously set Last-Modified header */
			/* from 304 Not Modified responses. */
			if ($this->cache->isNotModified($request, $response)) {
				return $response->withStatus(304);
			}

			/* Serialize the response data. */
			$fractal = new Manager();
			$fractal->setSerializer(new DataArraySerializer);
			$resource = new Item($portal, new PortalTransformer);
			$data = $fractal->createData($resource)->toArray();

			return $response->withStatus(200)
				->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}
		else {
			throw new NotFoundException("Portal not found.", 404);
		}
	}


	function create($request, $response, $arguments)
	{
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.create"])) {
			throw new ForbiddenException("Token not allowed to create portals", 403);
		}

		$allPostPutVars = $request->getParsedBody();

		$portalName = $allPostPutVars[ 'portal_name' ];
		$portalCode = $allPostPutVars[ 'portal_code' ];
		$rootDirectory = $allPostPutVars[ 'root_directory' ];
		$this->stopwatch->start("Validation");
		$isValid = $this->portalCreationValidator->assert($allPostPutVars);
		$this->stopwatch->stop("Validation");

		if (true === $isValid) {
			$this->stopwatch->start("Doctrine2");
			$portal = $this->portalRepository->insert($portalCode, $portalName, $rootDirectory);
			$first = $this->portalRepository->getByPortalCode($portalCode);
			if ($first) {
				$this->stopwatch->stop("Doctrine2");

				/* Add Last-Modified and ETag headers to response. */
				$response = $this->cache->withEtag($response, $first->getEtag());
				$response = $this->cache->withLastModified($response, $first->getModified()->getTimestamp());

				/* Serialize the response data. */
				$fractal = new Manager();
				$fractal->setSerializer(new DataArraySerializer);
				$resource = new Item($first, new PortalTransformer);
				$data = $fractal->createData($resource)->toArray();

				return $response->withStatus(201)
					->withHeader("Content-Type", "application/json")
					->withHeader("Location", $data[ "data" ][ "links" ][ "self" ])
					->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
			}
			else {
				return $response->withStatus(422)
					->withHeader("Content-Type", "application/json")
					->write(json_encode($this->portalCreationValidator->getErrorsConcat(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
			}
		}
	}

	public function delete($request, $response, $arguments)
	{
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.delete"])) {
			throw new ForbiddenException("Token not allowed to delete portals", 403);
		}

		/* Load existing Portal using provided uid */
		$icao = $arguments[ "icao" ];

		$this->stopwatch->start("Validation");
		$isValid = $this->portalGetValidator->assert($icao);
		$this->stopwatch->stop("Validation");

		if ($isValid) {
			$this->stopwatch->start("Doctrine2");
			$portal = $this->portalRepository->get($icao);
			$this->stopwatch->stop("Doctrine2");
		}
		else {
			return $response->withStatus(422)
				->withHeader("Content-Type", "application/json")
				->write(json_encode($this->portalCreationValidator->getErrorsConcat(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}

		if ($portal) {

			$this->portalRepository->softDeleteByPortalCode($icao);

			return $response->withStatus(204);
		}
		else {
			throw new NotFoundException("Portal not found.", 404);
		}
	}


	public function patch($request, $response, $arguments)
	{
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.update"])) {
			throw new ForbiddenException("Token not allowed to update portals", 403);
		}

		/* Load existing portal using provided uid */
		$icao = $arguments[ "icao" ];
		$allPostPutVars = $request->getParsedBody();

		$this->stopwatch->start("Validation");
		$isValid1 = $this->portalCreationValidator->assert($allPostPutVars);
		$isValid2 = $this->portalGetValidator->assert($icao);
		$this->stopwatch->stop("Validation");

		if ($isValid2) {
			$this->stopwatch->start("Doctrine2");
			$portal = $this->portalRepository->get($icao);
			$this->stopwatch->stop("Doctrine2");
		}
		else {
			return $response->withStatus(422)
				->withHeader("Content-Type", "application/json")
				->write(json_encode($this->portalCreationValidator->getErrorsConcat(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}

		/* PATCH requires If-Unmodified-Since or If-Match request header to be present. */
		if (false === $this->cache->hasStateValidator($request)) {
			throw new PreconditionRequiredException("PATCH request is required to be conditional", 428);
		}

		/* If-Unmodified-Since and If-Match request header handling. If in the meanwhile  */
		/* someone has modified the portal so respond with 412 Precondition Failed. */
		if (false === $this->cache->hasCurrentState($request, $portal->getEtag(), $portal->getModified()->getTimestamp())) {
			throw new PreconditionFailedException("Portal has been modified", 412);
		}

		/* Somehow map the data to Portal entity  */
		$allPostPutVars = $request->getParsedBody();
		$portalName = $allPostPutVars[ 'portal_name' ];
		$portalCode = $allPostPutVars[ 'portal_code' ];
		$rootDirectory = $allPostPutVars[ 'root_directory' ];

		$this->portalRepository->partialUpdateByPortalCode($portalCode, $portalName, $rootDirectory);

		/* Add Last-Modified and ETag headers to response. */
		$response = $this->cache->withEtag($response, $portal->getEtag());
		$response = $this->cache->withLastModified($response, $portal->getModified()->getTimestamp());
		$fractal = new Manager();
		$fractal->setSerializer(new DataArraySerializer);
		$resource = new Item($portal, new PortalTransformer);
		$data = $fractal->createData($resource)->toArray();

		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}

	public function put($request, $response, $arguments)
	{
		/* Check if token has needed scope. */
		if (false === $this->token->hasScope(["portal.all", "portal.update"])) {
			throw new ForbiddenException("Token not allowed to update portals", 403);
		}

		/* Load existing portal using provided uid */
		$icao = $arguments[ "icao" ];
		$allPostPutVars = $request->getParsedBody();

		$this->stopwatch->start("Validation");
		$isValid1 = $this->portalCreationValidator->assert($allPostPutVars);
		$isValid2 = $this->portalGetValidator->assert($icao);
		$this->stopwatch->stop("Validation");

		if ($isValid2) {
			$this->stopwatch->start("Doctrine2");
			$portal = $this->portalRepository->get($icao);
			$this->stopwatch->stop("Doctrine2");
		}
		else {
			return $response->withStatus(422)
				->withHeader("Content-Type", "application/json")
				->write(json_encode($this->portalCreationValidator->getErrorsConcat(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}

		/* PATCH requires If-Unmodified-Since or If-Match request header to be present. */
		if (false === $this->cache->hasStateValidator($request)) {
			throw new PreconditionRequiredException("PATCH request is required to be conditional", 428);
		}

		/* If-Unmodified-Since and If-Match request header handling. If in the meanwhile  */
		/* someone has modified the portal so respond with 412 Precondition Failed. */
		if (false === $this->cache->hasCurrentState($request, $portal->getEtag(), $portal->getModified()->getTimestamp())) {
			throw new PreconditionFailedException("Portal has been modified", 412);
		}

		/* Somehow map the data to Portal entity  */
		$allPostPutVars = $request->getParsedBody();
		$portalName = $allPostPutVars[ 'portal_name' ];
		$portalCode = $allPostPutVars[ 'portal_code' ];
		$rootDirectory = $allPostPutVars[ 'root_directory' ];

		$this->portalRepository->partialUpdateByPortalCode($portalCode, $portalName, $rootDirectory);

		/* Add Last-Modified and ETag headers to response. */
		$response = $this->cache->withEtag($response, $portal->getEtag());
		$response = $this->cache->withLastModified($response, $portal->getModified()->getTimestamp());
		$fractal = new Manager();
		$fractal->setSerializer(new DataArraySerializer);
		$resource = new Item($portal, new PortalTransformer);
		$data = $fractal->createData($resource)->toArray();

		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
}