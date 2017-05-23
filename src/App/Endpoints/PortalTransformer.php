<?php

namespace App\Endpoints;

use App\Entities\Portal;
use League\Fractal;

class PortalTransformer extends Fractal\TransformerAbstract
{
	public function transform(Portal $portal)
	{
		return [
			"id"             => (string) $portal->getPortalId() ? : null,
			"portal_code"    => (string) $portal->getPortalCode() ? : null,
			"root_directory" => (string) $portal->getRootDirectory() ? : null,
			"date_created"   => $portal->getCreated() ? : null,
			"date_modified"  => $portal->getModified() ? : null,
			"links"          => [
				"self" => "/api/v1/portal/{$portal->getPortalId()}"
			]
		];
	}
}