<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Token
 *
 * @ORM\Entity
 * @ORM\Table(name="token", uniqueConstraints={@ORM\UniqueConstraint(name="uc_id_token", columns={"id"}),
 *     , uniqueConstraints={@ORM\UniqueConstraint(name="uc_token", columns={"token"}),
 * indexes={@ORM\Index(name="idx_token", columns={"id"}),
 * schema="app_users"
 * )
 */
class Token
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Version
	 */
	protected $version;
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id_token", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idToken;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="issued", type="boolean", nullable=false)
	 */
	private $issued = '0';
	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="issued_at", type="datetime", nullable=false)
	 */
    private $issuedAt = 'CURRENT_TIMESTAMP';
	/**
	 * @var \string
	 *
	 * @ORM\Column(name="token", type="string", length=255, nullable=false)
	 */
	private $token;
    /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="user_tokens")
     */
    private $user;

	public function __construct()
	{

	}

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

	public function setIssuedAt($now)
	{
		$this->issuedAt = $now;
	}

	public function GetId()
	{
		return $this->idToken;
	}

	public function setIssued($int)
	{
		$this->issued = $int;
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function getToken()
	{
		return $this->token;
	}

}

