<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Annotations;
use Doctrine\ORM\Mapping as ORM;

/**
 * PortalFeature
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_feature", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}),
 * @ORM\UniqueConstraint(name="portal_feature_name", columns={"portal_feature_name"})},
 * indexes={@ORM\Index(name="idx_portal_feature", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class PortalFeature
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
	private $idPortalFeature;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="portal_feature_name", type="string", length=255, nullable=true)
	 */
	private $portalFeatureName;
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
	private $dateCreated = 'CURRENT_TIMESTAMP';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified_at", type="datetime", nullable=true)
	 */
	private $dateModified;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="modified_by", type="integer", nullable=false)
	 */
	private $modifiedBy;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="deactivated_by", type="integer", nullable=true)
	 */
	private $deactivatedBy;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="created_by", type="integer", nullable=true)
	 */
	private $createdBy;
	/**
	 * @ORM\ManyToOne(targetEntity="Portal", inversedBy="features")
	 */
	private $portal;
	/**
	 * @ORM\ManyToOne(targetEntity="PortalGeneration", inversedBy="portal_feature")
	 */
	private $portal_generation;
	/**
	 * @ORM\OneToOne(targetEntity="PortalHealthCheckURL", mappedBy="portal_feature")
	 */
	private $portalHealthCheckUrl;

	public function __construct()
	{
		// $this->portalHealthCheckUrl = new ArrayCollection();
	}

	public function setFeatureName($incFeatureName)
	{
		$this->portalFeatureName = $incFeatureName;
	}

	public function getFeatureName()
	{
		return $this->portalFeatureName;
	}

	public function getActive()
	{
		return $this->active;
	}

	public function setActive($incActive)
	{
		$this->active = $incActive;
	}

	public function getCreated()
	{
		return $this->dateCreated;
	}

	public function setModified()
	{
		$this->dateModified = new DateTime("now");
	}

	public function getModified()
	{
		return $this->dateModified;
	}

	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	public function setModifiedBy(User $incModifiedBy)
	{
		$this->modifiedBy = $incModifiedBy;
	}

	public function getDeactivatedBy()
	{
		return $this->deactivatedBy;
	}

	public function setDeactivatedBy($incDeactivatedBy)
	{
		$this->deactivatedBy = $incDeactivatedBy;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function setCreatedBy($incCreatedBy)
	{
		$this->createdBy = $incCreatedBy;
	}

	public function assignToPortal(Portal $incPortal)
	{
		$this->portal = $incPortal;
	}

	public function getAssignedPortal()
	{
		return $this->portal;
	}

	public function assignGeneration($incPortalGeneration)
	{
		$this->portal_generation = $incPortalGeneration;
	}

	public function getAssignedGeneration()
	{
		return $this->portal_generation;
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

