<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortalHealthCheckURL
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_health_check_url", uniqueConstraints={@ORM\UniqueConstraint(name="id_5", columns={"id"})},
 * indexes={@ORM\Index(name="idx_portal_health_check_url", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class PortalHealthCheckURL
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Version
	 */
	protected $version;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalHealthCheckURL;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="hc_root_path", type="string", length=255, nullable=true)
	 */
	private $hcRootPath;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=false)
	 */
	private $active = '0';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt = 'CURRENT_TIMESTAMP';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified_at", type="datetime", nullable=true)
	 */
	private $modifiedAt;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="modified_by", type="integer", nullable=true)
	 */
	private $modifiedBy;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="created_by", type="integer", nullable=true)
	 */
	private $createdBy;
	/**
	 * @ORM\OneToOne(targetEntity="PortalFeature", inversedBy="portalHealthCheckUrl")
	 */
	private $portal_feature;
	/**
	 * @ORM\OneToMany(targetEntity="PortalHealthCheckPulse", mappedBy="portalHealthCheckUrl")
	 */
	private $pulse;

	public function setHealthCheckRootPath($incHcRootPath)
	{
		$this->hcRootPath = $incHcRootPath;
	}

	public function getHealthCheckRootPath()
	{
		return $this->hcRootPath;
	}

	public function getActive()
	{
		return $this->active;
	}

	public function setActive($incActive)
	{
		$this->active = $incActive;
	}

	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	public function setModifiedBy(User $incModifiedBy)
	{
		$this->modifiedBy = $incModifiedBy;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function setCreatedBy($incCreatedBy)
	{
		$this->createdBy = $incCreatedBy;
	}

	public function assignPortalFeature(PortalFeature $incPortalFeature)
	{
		$this->portal_feature = $incPortalFeature;
	}

	public function getPortalFeature()
	{
		return $this->portal_feature;
	}

	public function getVersion()
	{
		return $this->version;
	}

	public function setVersion($incVersion)
	{
		$this->version = $incVersion;
	}

}

