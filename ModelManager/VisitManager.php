<?php

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Model\ParticipantInterface;

use Ant\SocialRestBundle\Model\VisitInterface;
use Ant\SocialRestBundle\Model\ProfileInterface;

use Ant\SocialRestBundle\Entity\AntDateTime;

abstract class VisitManager
{
	protected $validOrderFields = array('visitDate');

	public function createVisit()
	{
		$class = $this->getClass();
		$visit = new $class;
	
		return $visit;
	}
	
	public function saveVisit($visit)
	{
		$this->doSaveVisit($visit);
	}
	
	public function addVisit(ParticipantInterface $participant, ParticipantInterface $participantVoyeur)
	{
		$visit = $this->existTodayVisit($participant, $participantVoyeur);
		//no existe el objecto visit entonces lo creamos
		if (!is_object($visit)) {
			$visit = $this->createVisit();
			$visit->setParticipantVoyeur($participantVoyeur);
			$visit->setParticipant($participant);
		}else{
			$visit->setFrequency($visit->getFrequency()+1);
		}
		$this->saveVisit($visit);
	}
	
	public function existTodayVisit($participant, $participantVoyeur)
	{
		$d = new \DateTime('today');
		$timestamp = $d->getTimestamp();
		return $this->findOneVisitBy(array('participantVoyeur' => $participantVoyeur, 'participant' => $participant, 'visitDate' => $timestamp));
	}
	
	public function findVisitorsOf(ParticipantInterface $user, $maxResults, $orderString)
	{
		return $this->findVisitBy(array('participant' => $user->getId()), $this->buildOrdersArray($orderString));
	}

	private function buildOrdersArray($orderString)
	{
		$parts = $this->multiexplode(array(',', '='), $orderString);

		foreach ($parts as $field => $order){
			if(!in_array($field, $this->validOrderFields)){
				unset($parts[$field]);
			}
		}

		return $parts;
	}

	/**
	 *
	 * @param array $delimiters
	 * @param string $string string to explode
	 * @return array;
	 * @throws BadRequestHttpException
	 */
	private function multiexplode($delimiters, $string)
	{

		$result = array();
		$type = explode($delimiters[0], $string);
		foreach ($type as $pair){
			if (!strpos($pair, $delimiters[1])){
				throw new BadRequestHttpException('invalid_request');
			}
			list($k, $v) = explode($delimiters[1], $pair);
			$result[$k] = $v;
		}
		return $result;
	}

    /**
     * Finds last visits one user have done
     *
     * @param ParticipantInterface $user the user voyeur
     * @param integer $maxResults limit results
     * @param string $orderString
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
	public function findVoyeursOf(ParticipantInterface $user, $maxResults, $orderString)
	{
		return $this->findVoyeursBy(array('participantVoyeur' => $user->getId()), $this->buildOrdersArray($orderString), $maxResults);
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
    abstract protected function findVoyeursBy(array $criteria, $orderBy=null, $maxResults = null);
}