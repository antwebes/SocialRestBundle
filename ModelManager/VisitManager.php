<?php

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Model\ParticipantInterface;

use Ant\SocialRestBundle\Model\VisitInterface;
use Ant\SocialRestBundle\Model\ProfileInterface;

abstract class VisitManager
{
	public function createVisit()
	{
		$class = $this->getClass();
		$visit = new $class;
	
		return $visit;
	}
	
	public function saveVisit(VisitInterface $visit)
	{
		$this->doSaveVisit($visit);
	}
	
	public function addVisit(ProfileInterface $profile, $participant)
	{
		if (!$this->existTodayVisit($profile, $participant)) {
			$visit = $this->createVisit();
			$visit->setProfile($profile);
			$visit->setParticipant($participant);
			$this->saveVisit($visit);
		} 
	}
	
	public function existTodayVisit(ProfileInterface $profile, $participant)
	{
		return $this->findOneVisitBy(array('profile' => $profile, 'participant' => $participant, 'date' => new \DateTime('today')));
	}
	
	public function findVisitorsOf(ProfileInterface $profile, $maxResult)
	{
		return $this->findVisitBy(array('profile' => $profile), null , $maxResult);
	}
}