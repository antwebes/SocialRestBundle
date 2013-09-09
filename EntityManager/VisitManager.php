<?php

namespace Ant\SocialBundle\EntityManager;

use Ant\SocialBundle\Model\VisitInterface;
use Ant\SocialBundle\ModelManager\VisitManager as BaseVisitManager;

use Doctrine\ORM\EntityManager;

class VisitManager extends BaseVisitManager
{
	
	/**
	 * @var EntityManager
	 */
	protected $em;
	
	/**
	 * @var EntityRepository
	 */
	protected $repository;
	
	/**
	 * @var string
	 */
	protected $class;
	
	/**
	 * Constructor.
	 *
	 * @param \Doctrine\ORM\EntityManager                  $em
	 * @param string                                       $class
	 */
	public function __construct(EntityManager $em, $class)
	{
		$this->em = $em;
		$this->repository = $em->getRepository($class);
	
		$metadata = $em->getClassMetadata($class);
		$this->class = $metadata->name;
	}
	
	/**
	 * Finds one visit by the given criteria
	 *
	 * @param array $criteria
	 * @return VisitInterface
	 */
	public function findOneVisitBy(array $criteria)
	{
		return $this->repository->findOneBy($criteria);
	}
	/**
	 * Saves a visit
	 *
	 * @param VisitInterface $visit
	 */
	protected function doSaveVisit(VisitInterface $visit)
	{
		$this->em->persist($visit);
		$this->em->flush();
	}
	
	/**
	 * Returns the fully qualified visit class name
	 *
	 * @return string
	 **/
	public function getClass()
	{
		return $this->class;
	}
}