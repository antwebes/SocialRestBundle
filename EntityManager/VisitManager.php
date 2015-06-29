<?php

namespace Ant\SocialRestBundle\EntityManager;

use Ant\SocialRestBundle\Model\VisitInterface;
use Ant\SocialRestBundle\ModelManager\VisitManager as BaseVisitManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
	 * Finds visits by the given criteria
	 *
	 * @param array $criteria
	 * @return VisitInterface
	 */
	public function findVisitBy(array $criteria, $orderBy=null)
	{
		$qb = $this->repository->createQueryBuilder('v')->select('v');
		$whereConditions = array();
		
		
		foreach($criteria as $name => $value){
		  $whereConditions[] = $qb->expr()->eq('v.'.$name, ":".$name);
		  $qb->setParameter(":".$name, $value);
		}
		
		if(count($whereConditions) > 0){
		  $whereSql = call_user_func_array(array($qb->expr(), 'andX'), $whereConditions);
		  $qb->where($whereSql);
		}

		if($orderBy !== null){
			foreach($orderBy as $order){
				$qb->addOrderBy('v.'.$order['field'], $order['direction']);
			}
		}
		
		return new Paginator($qb->getQuery(), false);
	}
	/**
	 * Saves a visit
	 *
	 * @param VisitInterface $visit
	 */
	protected function doSaveVisit($visit){
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