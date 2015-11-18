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
            foreach($orderBy as $field => $direction){
                $qb->addOrderBy('v.'.$field, $direction);

                if($field == 'visitDate'){
                    $qb->addOrderBy('v.id', $direction); // if two entries have the same visitDate, the id is taken in account for the order
                }
            }
        }
        return new Paginator($qb->getQuery(), false);
    }

    /**
     * Finds visits by the given criteria
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $maxResults
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    protected function findVoyeursBy(array $criteria, $orderBy=null, $maxResults = null)
    {
        $qb = $this->repository
            ->createQueryBuilder('v')->select('v,
            (SELECT MAX(subq.visitDate) FROM '.$this->class.' AS subq WHERE subq.participant = v.participant AND subq.participantVoyeur = v.participantVoyeur) AS HIDDEN visitDate');

        $whereConditions = array();


        foreach($criteria as $name => $value){
            if($name != 'visitDate') {
                $whereConditions[] = $qb->expr()->eq('v.' . $name, ":" . $name);
            }else{
                $whereConditions[] = $qb->expr()->eq($name, ":" . $name);
            }

            $qb->setParameter(":".$name, $value);
        }

        if(count($whereConditions) > 0){
            $whereSql = call_user_func_array(array($qb->expr(), 'andX'), $whereConditions);
            $qb->where($whereSql);
        }

        if($orderBy !== null){
            foreach($orderBy as $field => $direction){
                if($field != 'visitDate'){
                    $qb->addOrderBy('v.'.$field, $direction);
                }else{
                    $qb->addOrderBy($field, $direction);

                    $qb->addOrderBy('v.id', $direction); // if two entries have the same visitDate, the id is taken in account for the order
                }
            }
        }

        $qb->groupBy('v.participant');

        if($maxResults != null && is_integer($maxResults)){
            $qb->getQuery()->setMaxResults($maxResults);
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