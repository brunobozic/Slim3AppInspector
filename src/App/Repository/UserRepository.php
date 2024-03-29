<?php
namespace App\Repository;

use App\Entities\User;

class UserRepository extends RepositoryBase
{
	public function getOne($username)
	{
		$user = $this->entityManager->getRepository('App\Entities\User')->findOneBy(
			array('user_name' => $username, 'active' => 1)
		);

		if ($user) {
			return $user->getArrayCopy();
		}
	}

	public function getAll($active)
	{
		$users = $this->entityManager->getRepository('App\Entities\User')->findAll(
		    array('active' => $active)
        );

		$users = array_map(
			function ($users) {
				return $users->getArrayCopy();
			},
			$users
		);

		return $users;
	}

    public function insert($username, $email, $password)
    {
        $auditUserName = $this->getOne('admin') ;

        $user = new User();
        $user->setActive(1);
        $user->setEmail($email);
        $user->setFirstName("");
        $user->setLastName("");
        $user->setPassword($password);

        if ($auditUserName) {
            $user->setUserName($username);
        }

        $user->setCreatedBy($auditUserName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }


    //    public function activateAccount()
    //   {
    //        $this->update([
    //            'active' => true,
    //          'active_hash' => null
    //       ]);
    //   }

    //   public function getAvatarUrl($options = [])
    //   {
    //       $size = isset($options['size']) ? $options['size']: 45;
//
    //      return 'http://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size . '&d=identicon';
    //  }
//
    //  public function updateRememberCredentials($identifier, $token)
    //  {
    //      $this->update([
    //          'remember_identifier' => $identifier,
    //         'remember_token' => $token
    //      ]);
    //  }
//
    //   public function removeRememberCredentials()
    //   {
    //      $this->updateRememberCredentials(null, null);
    //  }
//
    //   public function hasPermission($permission)
    //  {
    //       return (bool) $this->permissions->{$permission};
    //  }
//
    //   public function isAdmin()
    //   {
    //      return $this->hasPermission('is_admin');
    //   }
//
    //   public function permissions()
    //   {
    //       return $this->hasOne('Codecourse\User\UserPermission', 'user_id');
    //   }
}