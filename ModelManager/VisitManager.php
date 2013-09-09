<?php

namespace Ant\SocialBundle\ModelManager;

use Ant\SocialBundle\Model\VisitInterface;
use Ant\SocialBundle\Model\ParticipantInterface;
use Ant\SocialBundle\Model\ProfileInterface;

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
		$this->doSave($visit);
	}
	
	public function addVisit(ProfileInterface $profile, ParticipantInterface $participant)
	{
		if (!existTodayVisit()) {
			$visit = $this->createVisit();
			$visit->setProfile($profile);
			$visit->setParticipant($participant);
			$this->saveVisit($visit);
		} 
	}
	
	public function existTodayVisit(ProfileInterface $profile, ParticipantInterface $participant)
	{
		return $this->findOneVisitBy(array('profile' => $profile, 'participant' => $participant, 'date' => new \DateTime('now')));
	}
	
}