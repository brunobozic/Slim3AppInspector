<?php
namespace App\Endpoints;

use App\Repository\PulseEnqueueRepository;

final class PulseEnqueueEndpoint extends EndpointBase
{
	private $pulseEnqueueRepository;

	public function __construct(PulseEnqueueRepository $pulseEnqueueRepository)
	{
		$this->pulseEnqueueRepository = $pulseEnqueueRepository;
	}

	public function enqueueAll($request, $response, $args)
	{
		$returnValue = $this->pulseEnqueueRepository->enqueueAll();

		return $response->withJSON($returnValue);
	}

	public function enqueueOne($request, $response, $args)
	{
		$returnValue = $this->pulseEnqueueRepository->enqueueOne($args[ 'icao' ]);
		if ($returnValue) {
			return $response->withJSON($returnValue);
		}

		return $response->withStatus(404, 'No pulse was enqueued.');
	}
}