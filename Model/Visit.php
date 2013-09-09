<?php 

namespace Ant\SocialRestBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\Model\Profile;

abstract class Visit implements VisitInterface
{
	protected $participant;
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Profile", inversedBy="visits")
	 * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
	 */
	protected $profile;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="date", nullable=true)
	 * @Assert\Date
	 */
	protected $date;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $frequency;
	
	public function __construct()
	{
		$this->date = new \DateTime('now');
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function setProfile(ProfileInterface $profile)
	{
		$this->profile = $profile;
	}
	
	public function setParticipant(ParticipantInterface $participant)
	{
		$this->participant = $participant;
	}
	
	public function getParticipant()
	{
		return $this->participant;
	}
}