<?php
namespace App\Repository;

use App\Entities\Token;
use App\Entities\User;
use Doctrine\ORM\Repository;

class TokenRepository extends RepositoryBase
{
	public function getOneByUsername($username)
	{
        $user = $this->entityManager->getRepository('App\Entities\User')->findOneBy(
            array('user_name' => $username)
        );
        if ($user) {
            $token = $this->entityManager->getRepository('App\Entities\Token')->findOneBy(
                array('user_id' => $user->id_user)
            );
        }

        if (isset($token)) {
            if ($token) {
                return $token->getArrayCopy();
            }
        }
	}

	public function getAll($active)
	{
        $tokens = $this->entityManager->getRepository('App\Entities\Token')->findAll(

        );

        $tokens = array_map(
			function ($tokens) {
				return $tokens->getArrayCopy();
			},
            $tokens
		);

		return $tokens;
	}

    public function insert(User $user, $token)
    {
        $token = new Token();
        $token->setToken($token);
        $token->assignUser($user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();
    }

   // public function getFullName()
    // {
    //     if (!$this->first_name || !$this->last_name) {
    //         return null;
    //     }
//
    //      return "{$this->first_name} {$this->last_name}";
    //  }
//
    //  public function getFullNameOrUsername()
    //    {
    //        return $this->getFullName() ?: $this->user_name;
    //    }
//
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