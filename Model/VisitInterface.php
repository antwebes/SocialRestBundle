<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Model\ParticipantInterface;

interface VisitInterface{
	
	public function setParticipant(ParticipantInterface $participant);
	
	public function getParticipant();
	
}