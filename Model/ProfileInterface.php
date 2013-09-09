<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Model\ParticipantInterface;

interface ProfileInterface{
	
	public function setParticipant(ParticipantInterface $participant);
	
	public function getParticipant();
	
	public function setSexualOrientation($sexualOrientation);
	
	public function getSexualOrientation();
}