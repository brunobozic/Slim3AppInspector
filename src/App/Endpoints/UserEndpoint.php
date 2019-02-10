<?php
namespace App\Endpoints;

final class UserEndpoint extends EndpointBase
{
	public function getAll($request, $response, $args)
	{
		$users = $this->userRepository->getAll(1);

		return $response->withJSON($users);
	}

	public function getOne($request, $response, $args)
	{
		$user = $this->userRepository->getOne($args[ 'username' ]);

		if ($user) {
			return $response->withJSON($user);
		}

		return $response->withStatus(404, 'No user found with that username.');
	}
}