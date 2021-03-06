<?php

namespace Ant\SocialRestBundle\EntityManager;

use Ant\SocialRestBundle\Model\ProfileInterface;
use Ant\SocialRestBundle\ModelManager\ProfileManager as BaseProfileManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\ORM\EntityManager;

class ProfileManager extends BaseProfileManager
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
	 * 
	 * @var EventDispatcherInterface
	 */
	protected $dispatcher;

	/**
	 * Constructor.
	 *
	 * @param \Doctrine\ORM\EntityManager                  $em
	 * @param string                                       $class
	 * @param EventDispatcherInterface					   $dispatcher
	 */
	public function __construct(EntityManager $em, $class, EventDispatcherInterface $dispatcher)
	{
		$this->em = $em;
		$this->repository = $em->getRepository($class);
	
		$metadata = $em->getClassMetadata($class);
		$this->class = $metadata->name;
		
		$this->dispatcher = $dispatcher;
	}
	
	
	/**
	 * Saves a profile
	 *
	 * @param VisitInterface $profile
	 */
	protected function doSave(ProfileInterface $profile)
	{
		$this->em->persist($profile);
		$this->em->flush();
	}
	
	/**
	 * delete a profile
	 *
	 * @param ProfileInterface $profile
	 */
	protected function doDelete(ProfileInterface $profile)
	{
		$this->em->remove($profile);
		$this->em->flush();
	}
	
	/**
	 * Finds one profile by the given criteria
	 *
	 * @param array $criteria
	 * @return ProfileInterface
	 */
	public function findOneProfileBy(array $criteria)
	{
		return $this->repository->findOneBy($criteria);
	}
	
	/**
	 * Returns the fully qualified profile class name
	 *
	 * @return string
	 **/
	public function getClass()
	{
		return $this->class;
	}
}