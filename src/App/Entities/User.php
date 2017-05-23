<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}),
 * @ORM\UniqueConstraint(name="email", columns={"email"}),
 * @ORM\UniqueConstraint(name="username", columns={"username"})},
 * indexes={@ORM\Index(name="id_2", columns={"id"}),
 * @ORM\Index(name="username_2", columns={"username"})},
 * )                                                                                                                   
 *              schema="panasonic")
 */
class User
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
	private $id;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=20, nullable=false)
	 */
	private $username = '';
	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
	 */
	private $firstName;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
	 */
	private $lastName;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=255, nullable=false)
	 */
	private $password = '';
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=true)
	 */
	private $active;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="active_hash", type="string", length=255, nullable=true)
	 */
	private $activeHash;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="recover_hash", type="string", length=255, nullable=true)
	 */
	private $recoverHash;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
	 */
	private $updatedAt;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="modified_by", type="integer", nullable=true)
	 */
	private $modifiedBy;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=false)
	 */
	private $email;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="token", type="string", length=16, nullable=true)
	 */
	private $token;
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="token_expire", type="datetime", nullable=true)
	 */
	private $tokenExpire;
	/**
	 * @ORM\OneToMany(targetEntity="Portal", mappedBy="modified_by")
	 */
	private $portalsModified;
	/**
	 * @ORM\OneToMany(targetEntity="Portal", mappedBy="deactivated_by")
	 */
	private $portalsDeactivated;
	/**
	 * @ORM\OneToMany(targetEntity="Portal", mappedBy="created_by")
	 */
	private $portalsCreated;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="created_by", type="integer", nullable=true)
	 */
	private $createdBy;

	public function __construct()
	{
		$this->portalsDeactivated = new ArrayCollection();
		$this->portalsModified = new ArrayCollection();
		$this->portalsCreated = new ArrayCollection();
	}

	public function getVersion()
	{
		return $this->version;
	}

	public function setVersion($incVersion)
	{
		$this->version = $incVersion;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setPassword($hashedPassword)
	{
		$this->password = $hashedPassword;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	public function setCreatedAt($now)
	{
		$this->createdAt = $now;
	}

	public function GetId()
	{
		return $this->id;
	}

	public function setActive($int)
	{
		$this->active = $int;
	}

	public function setUserName($email)
	{
		$this->username = $email;
	}

	public function assignDeactivatedPortals(Portal $incDeactivatedPortal)
	{
		$this->portalsDeactivated = $incDeactivatedPortal;
	}

	public function getDeactivatedPortals()
	{
		return $this->portalsDeactivated;
	}

	public function assignModifiedPortals(Portal $incModifiedPortal)
	{
		$this->portalsModified = $incModifiedPortal;
	}

	public function getModifiedPortals()
	{
		return $this->portalsModified;
	}

	public function setToken($incToken)
	{
		$this->token = $incToken;
	}

	public function setTokenExpire($incTokenExpire)
	{
		$this->tokenExpire = $incTokenExpire;
	}

	public function setActiveHash($incActiveHash)
	{
		$this->activeHash = $incActiveHash;
	}

	public function setRecoverHash($incRecoverHash)
	{
		$this->recoverHash = $incRecoverHash;
	}

	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	public function setCreatedBy(User $incCreatedBy)
	{
		$this->createdBy = $incCreatedBy;
	}
}

