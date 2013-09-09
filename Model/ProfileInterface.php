<?php 

namespace Ant\SocialBundle\Model;

use Ant\SocialBundle\Model\ParticipantInterface;

interface ProfileInterface{
	
	public function setParticipant(ParticipantInterface $participant);
	
	public function getParticipant();
	
	public function setSexualOrientation($sexualOrientation);
	
	public function getSexualOrientation();
}