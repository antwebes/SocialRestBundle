<?php

namespace Ant\SocialBundle\EntityManager;

use Ant\SocialBundle\Model\ProfileInterface;
use Ant\SocialBundle\ModelManager\ProfileManager as BaseProfileManager;

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
	 * Saves a profile
	 *
	 * @param VisitInterface $profile
	 */
	protected function doSaveProfile(ProfileInterface $profile)
	{
		$this->em->persist($profile);
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