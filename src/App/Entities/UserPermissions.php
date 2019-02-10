<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Permissions
 *
 * @ORM\Entity
 * @ORM\Table(name="oermissions", uniqueConstraints={@ORM\UniqueConstraint(name="uc_id_permission", columns={"id"}),
 *     , uniqueConstraints={@ORM\UniqueConstraint(name="uc_name", columns={"name"}),
 * indexes={@ORM\Index(name="idx_permission", columns={"id"}),
 * schema="app_users"
 * )
 */
class Permission
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $version;
    /**
     * @var integer
     *
     * @ORM\Column(name="id_permission", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPermission;
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
    /**
     * @var \string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $createdAt = 'CURRENT_TIMESTAMP';
    /**
     * @var \string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @var \string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;
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
        $this->createdAt = $now;
    }

    public function GetId()
    {
        return $this->idPermission;
    }

    public function setActive($int)
    {
        $this->active = $int;
    }

    public function setPermissionName($permissionName)
    {
        $this->name = $permissionName;
    }

    public function getPermissionName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setActiveFrom($activeFrom)
    {
        $this->activeFrom = $activeFrom;
    }

    public function getActiveFrom()
    {
        return $this->activeFrom;
    }

    public function setActiveTo($activeTo)
    {
        $this->activeTo = $activeTo;
    }

    public function getActiveTo()
    {
        return $this->activeTo;
    }
}

