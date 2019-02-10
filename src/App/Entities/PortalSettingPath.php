<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * PortalSettingPath
 *
 * @ORM\Entity
 * @ORM\Table(name="portal_setting_path", uniqueConstraints={@ORM\UniqueConstraint(name="id_7", columns={"id"}),
 * @ORM\UniqueConstraint(name="portal_setting_file_content_id", columns={"portal_setting_file_content_id"})},
 * schema="app_inspector"
 * )
 */
class PortalSettingPath
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idPortalSettingPath;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_feature_id", type="integer", nullable=false)
	 */
	private $portalFeatureId;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_id", type="integer", nullable=false)
	 */
	private $portalId;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="portal_setting_file_content_id", type="integer", nullable=true)
	 */
	private $portalSettingFileContentId;


}

