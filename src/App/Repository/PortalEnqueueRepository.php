<?php
namespace App\Repository;

use Doctrine\ORM\Repository;

class PulseEnqueueRepository extends RepositoryBase
{

	public function enqueueOne($icao)
	{
		$returnValue = false;
		$portalHealthChekckUrl = $this->entityManager->getRepository('App\Entities\PortalHealthCheckUrl')->findOneBy(
			array('icao' => $icao)
		);

		if ($portalHealthChekckUrl) {
			$returnValue = $this->entityManager->getRepository('App\Entities\PortalHealthCheckPulse')->enqueueOne($portalHealthChekckUrl);
		}
		return $returnValue;
	}

	public function enqueueAll()
	{
		$allPortalsList = $this->entityManager->getRepository('App\Entities\Portal')->findAll();
		$returnValue = $this->entityManager->getRepository('App\Entities\PulseEnqueueRepository')->enqueueAll($allPortalsList);

		return $returnValue;
	}
}