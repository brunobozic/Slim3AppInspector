<?php

namespace App\Entities;

use Doctrine\Common\Annotations;
use Doctrine\ORM\Mapping as ORM;

/**
 * PortalHealthCheckPulse
 *
 * @ORM\Table(name="portal_version_check_pulse", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})},
 *     indexes={@ORM\Index(name="idx_portal_version_check_pulse", columns={"id"})},
 * schema="app_inspector"
 * )
 * @ORM\Entity
 */
class PortalVersionCheckPulse
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalVersionCheckPulse;

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
	private $versionCheckResponse;

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
	private $createdAt = 'CURRENT_TIMESTAMP';

	/**
	 * @ORM\ManyToOne(targetEntity="PortalVersionCheckPath", inversedBy="pulse")
	 */
	private $portal_version_check_path;
}

