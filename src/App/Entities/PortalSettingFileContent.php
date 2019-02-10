<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortalSettingFileContent
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_setting_file_content", uniqueConstraints={@ORM\UniqueConstraint(name="id_6", columns={"id"}),
 * @ORM\UniqueConstraint(name="id_666", columns={"id"})},
 * indexes={@ORM\Index(name="file_content", columns={"file_content"})},
 * schema="app_inspector"
 * )
 */
class PortalSettingFileContent
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalSettingContent;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_setting_path_id", type="integer", nullable=false)
	 */
	private $portalSettingPathId;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_id", type="integer", nullable=false)
	 */
	private $portalId;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_feature_id", type="integer", nullable=true)
	 */
	private $portalFeatureId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="file_content", type="string", length=1000, nullable=true)
	 */
	private $fileContent;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="file_extension", type="string", length=6, nullable=true)
	 */
	private $fileExtension;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
	 */
	private $fileName;


}

