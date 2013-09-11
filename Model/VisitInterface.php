<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Entity\AntDateTime;

interface VisitInterface{
	
	public function setParticipant($participant);
	
	public function getParticipant();
	
	public function setDate($date);
	
	public function getDate();
	
	public function setProfile(ProfileInterface $profile);
	
	
}