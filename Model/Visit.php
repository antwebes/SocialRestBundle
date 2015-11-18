<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\Model\Profile;
// use Ant\SocialRestBundle\Entity\AntDateTime;

use Symfony\Component\Validator\Constraints as Assert;

abstract class Visit implements VisitInterface
{	
	public function __construct()
	{
 		$date = new \DateTime('today');
 		$this->visitDate = $date->getTimestamp();
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}
	

	public function setVisitDate($visitDate)
	{
		$this->visitDate = $visitDate;
	}
	
	public function getVisitDate()
	{
		return $this->visitDate;
	}
	
	public function setProfile(ProfileInterface $profile)
	{
		$this->profile = $profile;
	}
	
	public function setParticipant($participant)
	{
		$this->participant = $participant;
	}
	public function getParticipant()
	{
		return $this->participant;
	}
	
	public function setParticipantVoyeur($participant)
	{
		$this->participantVoyeur = $participant;
	}
	public function getParticipantVoyeur()
	{
		return $this->participantVoyeur;
	}
	
	public function setFrequency($frequency)
	{
		$this->frequency = $frequency;
	}
	
	public function getFrequency()
	{
		return $this->frequency;
	}
}