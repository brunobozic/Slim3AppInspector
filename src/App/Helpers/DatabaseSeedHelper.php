<?php
namespace App\Helpers;

use App\Entities\Portal;
use App\Entities\PortalFeature;
use App\Entities\PortalGeneration;
use App\Entities\PortalHealthCheckPulse;
use App\Entities\PortalHealthCheckURL;
use App\Entities\User;
use DateTime;

class DatabaseSeedHelper extends BaseHelper
{
	public function SeedAdminUser()
	{
		$user = new User;
		$user->setFirstName('Admin');
		$user->setLastName('Admin');
		$user->setActive(1);
		$user->setEmail('admin@admin.com');
		$user->setCreatedAt(new DateTime());
		$user->setPassword('abcdef');
		$user->setUserName('Admin');
		$user->setActiveHash('kkk');
		$user->setRecoverHash('kkk');
		$user->setToken('kkk');
		$user->setTokenExpire('kkk');

		$this->container->get('em')->persist($user);
		$this->container->get('em')->flush();
	}

	public function SeedPortal()
	{
		$userName = 'Admin';
		$user = $this->container->get('em')->getRepository('User')
			->findOneBy(array('username' => $userName));

		$portal = new Portal();
		$portal->setActive(1);
		$portal->setPortalCode('AIJ-Tactel');
		$portal->setModified();
		$portal->setModifiedBy($user);
		$portal->setRootDirectory('/opt2/wisp-aij-tactel/public/');

		$this->container->get('em')->persist($portal);
		$this->container->get('em')->flush();
	}

	public function SeedPortalGeneration()
	{
		$userName = 'Admin';
		$user = $this->container->get('em')->getRepository('User')
			->findOneBy(array('username' => $userName));

		$portal_generation = new PortalGeneration();
		$portal_generation->setActive(1);
		$portal_generation->setGenerationName('Tactel');
		$portal_generation->setCreated(new DateTime());
		$portal_generation->setModifiedBy($user);

		$this->container->get('em')->persist($portal_generation);
		$this->container->get('em')->flush();
	}

	public function SeedPortalFeature()
	{
		$userName = 'Admin';
		$user = $this->container->get('em')->getRepository('User')
			->findOneBy(array('username' => $userName));

		$generationName = 'Tactel';
		$generation = $this->container->get('em')->getRepository('PortalGeneration')
			->findOneBy(array('generationName' => $generationName));

		$portalName = 'AIJ-Tactel';
		$portal = $this->container->get('em')->getRepository('Portal')
			->findOneBy(array('generationName' => $portalName));

		$portal_feature = new PortalFeature();
		$portal_feature->setActive(1);
		$portal_feature->assignToPortal($portal);
		$portal_feature->setFeatureName('Crowdin');
		$portal_feature->setModified();
		$portal_feature->setModifiedBy($user);
		$portal_feature->assignGeneration($generation);

		$this->container->get('em')->persist($portal_feature);
		$this->container->get('em')->flush();
	}

	public function SeedPortalHealthCheckURL()
	{
		$userName = 'Admin';
		$user = $this->container->get('em')->getRepository('User')
			->findOneBy(array('username' => $userName));

		$portalFeatureName = 'Crowdin';
		$portalFeature = $this->container->get('em')->getRepository('PortalFeature')
			->findOneBy(array('portalFeatureName' => $portalFeatureName));

		$portal = new PortalHealthCheckURL();
		$portal->setActive(1);
		$portal->setModifiedBy($user);
		$portal->setHealthCheckRootPath('https://inflight.pacwisp.net/wisp-aij-tactel/aij-tactel-crowdin');
		$portal->assignPortalFeature($portalFeature);

		$this->container->get('em')->persist($portal);
		$this->container->get('em')->flush();
	}

	public function SeedPortalHealthCheckPulse()
	{
		$portalHealthCheckURLID = 1;
		$portalHealthCheckUrl = $this->container->get('em')->getRepository('PortalHealthCheckURL')
			->findOneBy(array('id' => $portalHealthCheckURLID));
		
		$healthCheckPulse = new PortalHealthCheckPulse();
		$healthCheckPulse->setCreated(new DateTime());
		$healthCheckPulse->setHealthcheckResponse('FakeResponse');
		$healthCheckPulse->setPortalVersion('6.6.6');
		$healthCheckPulse->setResponseLatency(999999);
		$healthCheckPulse->assignPortalHealthCheckUrl($portalHealthCheckUrl);

		$this->container->get('em')->persist($healthCheckPulse);
		$this->container->get('em')->flush();
	}
}

