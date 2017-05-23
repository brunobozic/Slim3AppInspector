<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Annotations;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PortalGeneration
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_generation", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}),
 * @ORM\UniqueConstraint(name="generation_name", columns={"generation_name"})},
 * indexes={@ORM\Index(name="idx_portal_generation", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class PortalGeneration
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalGeneration;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="generation_name", type="string", length=64, nullable=true)
	 */
	private $generationName;

	public function setGenerationName($incGenerationName)
	{
		$this->generationName = $incGenerationName;
	}

	public function getGenerationName()
	{
		return $this->generationName;
	}

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=false)
	 */
	private $active = '0';

	public function setActive($incActive)
	{
		$this->active = $incActive;
	}

	public function getActive()
	{
		return $this->active;
	}

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $dateCreated = 'CURRENT_TIMESTAMP';

	public function getCreated()
	{
		return $this->dateCreated;
	}

	public function setCreated($incDateCreated)
	{
		$this->dateCreated = $incDateCreated;
	}

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="modified_at", type="datetime", nullable=true)
	 */
	private $dateModified;

	public function setModified()
	{
		$this->dateModified = new DateTime("now");
	}

	public function getModified()
	{
		return $this->dateModified;
	}

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="modified_by", type="integer", nullable=true)
	 */
	private $modifiedBy;

	public function setModifiedBy(User $incUser)
	{
		$this->modifiedBy = $incUser;
	}

	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="created_by", type="integer", nullable=true)
	 */
	private $createdBy;

	public function setCreatedBy($incCreatedBy)
	{
		$this->createdBy = $incCreatedBy;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="deactivated_by", type="integer", nullable=true)
	 */
	private $deactivatedBy;

	/**
	 * @ORM\OneToMany(targetEntity="PortalFeature", mappedBy="PortalGeneration")
	 */
	private $portal_features;

	public function __construct()
	{
		$this->portal_features = new ArrayCollection();
	}

	public function getPortalFeatures()
	{
		return $this->portal_features;
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Version
	 */
	protected $version;

	public function setVersion($incVersion)
	{
		$this->version = $incVersion;
	}

	public function getVersion()
	{
		return $this->version;
	}

}

