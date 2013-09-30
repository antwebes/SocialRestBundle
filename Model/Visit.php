<?php 

namespace Ant\SocialRestBundle\Model;

use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\Model\Profile;
use Ant\SocialRestBundle\Entity\AntDateTime;

use Symfony\Component\Validator\Constraints as Assert;

abstract class Visit implements VisitInterface
{
	protected $participant;
	
	protected $participantVoyeur;
	
	protected $date;
	
	protected $frequency;
	
	public function __construct()
	{
		$this->date = new AntDateTime('today');
	}
	

	public function setDate($date)
	{
		$this->date = $date;
	}
	
	public function getDate()
	{
		return $this->date;
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