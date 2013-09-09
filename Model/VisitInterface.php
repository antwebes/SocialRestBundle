<?php 

namespace Ant\SocialBundle\Model;

use Ant\SocialBundle\Model\ParticipantInterface;

interface VisitInterface{
	
	public function setParticipant(ParticipantInterface $participant);
	
	public function getParticipant();
	
}