<?php
namespace App\Repository;

use Doctrine\ORM\Repository;

class UserRepository extends RepositoryBase
{
	public function getOne($username)
	{
		$user = $this->entityManager->getRepository('App\Entities\User')->findOneBy(
			array('slug' => $username)
		);
		if ($user) {
			return $user->getArrayCopy();
		}
	}

	public function getAll()
	{
		$users = $this->entityManager->getRepository('App\Entities\User')->findAll();
		$users = array_map(
			function ($users) {
				return $users->getArrayCopy();
			},
			$users
		);

		return $users;
	}
}