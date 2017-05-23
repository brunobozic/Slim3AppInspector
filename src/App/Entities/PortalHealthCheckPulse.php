<?php

namespace App\Entities;

use Doctrine\Common\Annotations;
use Doctrine\ORM\Mapping as ORM;

/**
 * PortalHealthCheckPulse
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_health_check_pulse", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})},
 * indexes={@ORM\Index(name="idx_portal_health_check_pulse", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class PortalHealthCheckPulse
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalHCPulse;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="latency", type="string", length=255, nullable=true)
	 */
	private $responseLatency;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="response", type="string", length=255, nullable=true)
	 */
	private $healthcheckResponse;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="portal_version", type="string", length=255, nullable=true)
	 */
	private $healthcheckPortalVersion;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $dateCreated = 'CURRENT_TIMESTAMP';
	/**
	 * @ORM\ManyToOne(targetEntity="PortalHealthCheckURL", inversedBy="pulse")
	 */
	private $portal_health_check_url;

	public function getResponseLatency()
	{
		return $this->responseLatency;
	}

	public function setResponseLatency($incResponseLatency)
	{
		$this->responseLatency = $incResponseLatency;
	}

	public function getHealthcheckResponse()
	{
		return $this->healthcheckResponse;
	}

	public function setHealthcheckResponse($incHealthcheckResponse)
	{
		$this->healthcheckResponse = $incHealthcheckResponse;
	}

	public function getPortalVersion()
	{
		return $this->healthcheckPortalVersion;
	}

	public function setPortalVersion($incPortalVersion)
	{
		$this->healthcheckPortalVersion = $incPortalVersion;
	}

	public function getCreated()
	{
		return $this->dateCreated;
	}

	public function setCreated($incDateCreated)
	{
		$this->dateCreated = $incDateCreated;
	}

	public function getAssignedPortalHealthCheckUrl()
	{
		return $this->portal_health_check_url;
	}

	public function assignPortalHealthCheckUrl(PortalHealthCheckURL $incPortalHealthCheckUrl)
	{
		$this->portal_health_check_url = $incPortalHealthCheckUrl;
	}

}

