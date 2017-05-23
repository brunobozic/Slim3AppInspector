<?php
namespace App\Endpoints;

use App\Repository\UserRepository;

final class UserEndpoint extends EndpointBase
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function getAll($request, $response, $args)
	{
		$users = $this->userRepository->getAll();

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