<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Entity\AntDateTime;

interface VisitInterface{
	public function setId($id);

	public function getId();

	public function setParticipant($participant);
	
	public function getParticipant();
	
	public function setVisitDate($visitDate);
	
	public function getVisitDate();
	
	public function setProfile(ProfileInterface $profile);
	
	public function setFrequency($frequency);
	
	public function getFrequency();
	
	public function setParticipantVoyeur($participant);
	
	public function getParticipantVoyeur();
	
	
}