<?php
namespace App\Endpoints;

use App\Repository\PortalHCPulseRepository;

final class PortalHCPulseEndpoint extends EndpointBase
{
	private $portalHCPulseRepository;

	public function __construct(PortalHCPulseRepository $portalHCPulseRepository)
	{
		$this->portalHCPulseRepository = $portalHCPulseRepository;
	}

	public function getAll($request, $response, $args)
	{
		$portals = $this->portalHCPulseRepository->get();

		return $response->withJSON($portals);
	}

	public function getOne($request, $response, $args)
	{
		$portal = $this->portalHCPulseRepository->get($args[ 'icao' ]);
		if ($portal) {
			return $response->withJSON($portal);
		}

		return $response->withStatus(404, 'No portal found with that portal code.');
	}
}