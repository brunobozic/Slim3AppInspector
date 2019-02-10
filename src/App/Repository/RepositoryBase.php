<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

abstract class RepositoryBase
{
	protected $logger;
	protected $tracer;
	protected $entityManager = null;

    /**
     * RepositoryBase constructor.
     * @param LoggerInterface $logger
     * @param EntityManager $em
     */
    public function __construct(LoggerInterface $logger, EntityManager $em)
	{
		$this->logger = $logger;
		$this->entityManager = $em;
	}
}