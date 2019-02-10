<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Activations
 *
 * @ORM\Entity
 * @ORM\Table(name="activations", uniqueConstraints={@ORM\UniqueConstraint(name="uc_id_activation", columns={"id"}),
 *     , uniqueConstraints={@ORM\UniqueConstraint(name="uc_activation_code", columns={"activation_code"}),
 * indexes={@ORM\Index(name="idx_activation", columns={"id"}),
 * schema="app_users"
 * )
 */
class UserActivation
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Version
	 */
	protected $version;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id_activation", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idActivation;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="activated", type="boolean", nullable=false)
	 */
	private $activated = '0';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="activated_at", type="datetime", nullable=false)
	 */
    private $activatedAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
	private $createdAt = 'CURRENT_TIMESTAMP';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;
	/**
	 * @var \string
	 *
	 * @ORM\Column(name="activation_code", type="string", length=255, nullable=false)
	 */
	private $activation_code;

    /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="user_activations")
     */
    private $user;

	public function __construct()
	{

	}
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '0';
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active_from", type="datetime", nullable=false)
     */
    private $activeFrom = 'CURRENT_TIMESTAMP';
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active_to", type="datetime", nullable=true)
     */
    private $activeTo;

    public function assignUser(User $incUser)
    {
        $this->user = $incUser;
    }

    public function getUser()
    {
        return $this->user;
    }

	public function getVersion()
	{
		return $this->version;
	}

	public function setVersion($incVersion)
	{
		$this->version = $incVersion;
	}

	public function setCreatedAt($now)
	{
		$this->createdAt = $now;
	}

	public function GetId()
	{
		return $this->idActivation;
	}

	public function setActivated($int)
	{
		$this->activated = $int;
	}

	public function setActivationCode($activation_code)
	{
		$this->activation_code = $activation_code;
	}

	public function getActivated()
	{
		return $this->activated;
	}

	public function getActivationCode()
	{
		return $this->activation_code;
	}
}

