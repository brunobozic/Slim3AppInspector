<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

abstract class RepositoryBase
{
	protected $logger;
	protected $tracer;
	protected $entityManager = null;

	public function __construct(LoggerInterface $logger, LoggerInterface $tracer, EntityManager $em)
	{
		$this->logger = $logger;
		$this->tracer = $tracer;
		$this->entityManager = $em;
	}
}