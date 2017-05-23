<?php

namespace App\Repository;

use App\Entities\Portal;
use Doctrine\ORM\Query;
use Doctrine\ORM\Repository;

class PortalRepository extends RepositoryBase
{
	public function get($icao)
	{
		$portal = $this->entityManager->getRepository('App\Entities\Portal')->findOneBy(
			array('portalCode' => $icao, 'active' => 1)
		);
		if ($portal) {
			return $portal;
		}
	}

	public function getAll()
	{
		$query = $this->entityManager->createQuery('SELECT NEW App\Repository\PortalDTO(p.portalCode, p.rootDirectory, p.dateCreated, p.dateModified, p.e_tag) FROM App\Entities\Portal p WHERE p.active = 1');
		$portals = $query->getResult();

		return $portals;
	}

	public function getLastUpdated()
	{
		$query = $this->entityManager->createQuery('SELECT p FROM App\Entities\Portal p WHERE p.active = 1 ORDER BY p.dateModified DESC');
		$portal = $query->setMaxResults(1)->getResult();

		return $portal;
	}

	public function getAllOrderedByNewest()
	{
		$query = $this->entityManager->createQuery('SELECT p FROM App\Entities\Portal p WHERE p.active = 1 ORDER BY p.dateModified DESC');
		$portal = $query->getResult();

		return $portal;
	}

	public function insert($portal_code, $portal_name, $root_path)
	{
		$userName = 'admin';
		$user = $this->entityManager->getRepository('App\Entities\User')
			->findOneBy(array('username' => $userName, 'active' => 1));
	
		$portal = new Portal();
		$portal->setActive(1);
		$portal->setPortalCode($portal_code);
		$portal->setModified();
		$portal->setCreated();
		$portal->setPortalName($portal_name);
		$portal->setRootDirectory($root_path);
		$portal->setModifiedBy($user);
		$portal->setCreatedBy($user);
		$this->entityManager->persist($portal);
		$this->entityManager->flush();
	}

	public function getByPortalCode($portal_code)
	{
		$portal = $this->entityManager->getRepository('App\Entities\Portal')
			->findOneBy(array('portalCode' => $portal_code, 'active' => 1));

		return $portal;
	}

	public function deleteByPortalCode($portal_code)
	{
		$userName = 'admin';
		$user = $this->entityManager->getRepository('App\Entities\User')
			->findOneBy(array('username' => $userName, 'active' => 1));

		$portal = $this->entityManager->getRepository('App\Entities\Portal')
			->findOneBy(array('portalCode' => $portal_code, 'active' => 1));

		$portal->setModified();
		$portal->setModifiedBy($user);
		$this->entityManager->remove($portal);
		$this->entityManager->flush();
	}

	public function softDeleteByPortalCode($portal_code)
	{
		$userName = 'admin';
		$user = $this->entityManager->getRepository('App\Entities\User')
			->findOneBy(array('username' => $userName, 'active' => 1));

		$portal = $this->entityManager->getRepository('App\Entities\Portal')
			->findOneBy(array('portalCode' => $portal_code));
		$portal->setActive(0);
		$portal->setModified();
		$portal->setModifiedBy($user);
		$this->entityManager->persist($portal);
		$this->entityManager->flush();
	}

	public function unDeleteByPortalCode($portal_code)
	{
		$userName = 'admin';
		$user = $this->entityManager->getRepository('App\Entities\User')
			->findOneBy(array('username' => $userName, 'active' => 1));


		$portal = $this->entityManager->getRepository('App\Entities\Portal')
			->findOneBy(array('portalCode' => $portal_code));
		$portal->setActive(1);
		$portal->setModified();
		$portal->setModifiedBy($user);
		$this->entityManager->persist($portal);
		$this->entityManager->flush();
	}

	public function partialUpdateByPortalCode($portal_code, $portal_name, $root_path)
	{
		$userName = 'admin';
		$user = $this->entityManager->getRepository('App\Entities\User')
			->findOneBy(array('username' => $userName, 'active' => 1));

		$portal = $this->entityManager->getRepository('App\Entities\Portal')
			->findOneBy(array('portalCode' => $portal_code, 'active' => 1));

		if (isset($portal_name)) {
			$portal->setPortalName($portal_name);
		}

		if (isset($root_path)) {
			$portal->setRootDirectory($root_path);
		}

		$portal->setModified();
		$portal->setModifiedBy($user);
		$this->entityManager->persist($portal);
		$this->entityManager->flush();
	}
}