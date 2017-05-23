<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Annotations;
use Doctrine\ORM\Mapping as ORM;

/**
 * Portal
 *
 * @ORM\Entity
 * @ORM\Table(name="portal", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}),
 * @ORM\UniqueConstraint(name="portal_code", columns={"portal_code"})},
 * indexes={@ORM\Index(name="idx_id_portal", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class Portal
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
	private $idPortal;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="portal_code", type="string", length=60, nullable=false)
	 */
	private $portalCode;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="portal_name", type="string", length=60, nullable=false)
	 */
	private $portalName;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="root_directory", type="string", length=255, nullable=false)
	 */
	private $rootDirectory;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=false)
	 */
	private $active = '0';
	/**
	 * @var DateTime
	 *
	 * @ORM\Column(name="date_created", type="datetime", nullable=false)
	 */
	private $dateCreated = 'CURRENT_TIMESTAMP';
	/**
	 * @var DateTime
	 *
	 * @ORM\Column(name="date_modified", type="datetime", nullable=true)
	 */
	private $dateModified;
	/**
	 * Many Portals can be modified by one User.
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="portalsModified")
	 * @ORM\JoinColumn(name="modified_by", referencedColumnName="id")
	 */
	private $modifiedBy;
	/**
	 * Many Portals can be modified by one User.
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="portalsDeactivated")
	 * @ORM\JoinColumn(name="deactivated_by", referencedColumnName="id")
	 */
	private $deactivatedBy;

	/**
	 * Many Portals can be modified by one User.
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="portalsCreated")
	 * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
	 */
	private $createdBy;

	public function getPortalCode()
	{
		return $this->portalCode;
	}

	public function setPortalCode($incPortalCode)
	{
		$this->portalCode = $incPortalCode;
	}

	public function getPortalName()
	{
		return $this->portalName;
	}

	public function setPortalName($incPortalName)
	{
		$this->portalName = $incPortalName;
	}

	public function getRootDirectory()
	{
		return $this->rootDirectory;
	}

	public function setRootDirectory($incRootDirectory)
	{
		$this->rootDirectory = $incRootDirectory;
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

	public function setCreated()
	{
		$this->dateCreated = new DateTime("now");
	}

	public function setModified()
	{
		$this->dateModified = new DateTime("now");
	}

	public function getModified()
	{
		return $this->dateModified;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function setCreatedBy($incCreatedBy)
	{
		$this->createdBy = $incCreatedBy;
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

	public function setDeactivatedBy(User $incDeactivatedBy)
	{
		$this->deactivatedBy = $incDeactivatedBy;
	}

	public function getEtag()
	{
		return md5($this->idPortal . $this->getTimestamp());
	}

	public function getTimestamp()
	{
		return $this->dateModified->getTimestamp();
	}

	public function getPortalId()
	{
		return $this->idPortal;
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

