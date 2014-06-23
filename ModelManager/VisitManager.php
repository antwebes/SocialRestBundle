<?php

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Model\ParticipantInterface;

use Ant\SocialRestBundle\Model\VisitInterface;
use Ant\SocialRestBundle\Model\ProfileInterface;

use Ant\SocialRestBundle\Entity\AntDateTime;

abstract class VisitManager
{
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
	
	public function findVisitorsOf(ParticipantInterface $user)
	{
		return $this->findVisitBy(array('participant' => $user->getId()), null);
	}
}