<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortalVersionCheckPath
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_version_check_path", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})},
 * indexes={@ORM\Index(name="idx_portal_version_check_path", columns={"id"})},
 * schema="app_inspector"
 * )
 */
class PortalVersionCheckPath
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
	private $idPortalVersionCheckPath;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="version_path", type="string", length=255, nullable=true)
	 */
	private $versionPath = '/js/';
	/**
	 * @var string
	 *
	 * @ORM\Column(name="version_file_mask", type="string", length=64, nullable=true)
	 */
	private $versionFileMask = 'templates.min';
	/**
	 * @var string
	 *
	 * @ORM\Column(name="version_root_path", type="string", length=255, nullable=true)
	 */
	private $versionRootPath;
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
	 * @ORM\ManyToOne(targetEntity="PortalFeature", inversedBy="portalVersionCheckUrlFeature")
	 */
	private $portal_feature;
	/**
	 * @ORM\OneToMany(targetEntity="PortalVersionCheckPulse", mappedBy="portalVersionCheckPath")
	 */
	private $pulse;
}

