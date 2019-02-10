<?php
namespace App\Endpoints;

use App\Repository\PortalRepository;
use App\Repository\UserRepository;
use App\Token;
use App\Validators\PortalCreationValidator;
use App\Validators\PortalGetValidator;
use Micheh\Cache\CacheUtil;
use Tuupola\Middleware\ServerTiming\Stopwatch;

abstract class EndpointBase
{
	protected $portalRepository;
	protected $cache;
	protected $portalCreationValidator;
	protected $token;
	protected $stopwatch;

	public function __construct(
	        PortalRepository $portalRepository
            , UserRepository $userRepository
            , CacheUtil $cache
            , PortalCreationValidator $creationValidator
            , PortalGetValidator $getValidator
            , Token $token
            , Stopwatch $stopwatch
    )
	{
		$this->portalRepository = $portalRepository;
        $this->userRepository = $userRepository;
		$this->cache = $cache;
		$this->portalCreationValidator = $creationValidator;
		$this->portalGetValidator = $getValidator;
		$this->token = $token;
		$this->stopwatch = $stopwatch;
	}
}