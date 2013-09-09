<?php 

namespace Ant\SocialBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Ant\SocialBundle\Model\ParticipantInterface;

abstract class Profile implements ProfileInterface {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * Participant owner of the profile
	 *
	 * @var ParticipantInterface
	 */
	protected $participant;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Assert\Length(
	 * 	max = "600")
	 */
	protected $about;
	
	/**
	 * @ORM\Column(type="string")
	 * @Assert\Choice(
	 * choices = {"heterosexual", "homosexual", "bisexual"},
	 * message = "profile.sexualOrientation.choice"
	 * )
	 */
	protected $sexualOrientation;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 * @Assert\DateTime
	 */
	protected $updatedAt;
	
	/**
	 * @ORM\Column(type="datetime")
	 *
	 * @Assert\Date
	 */
	protected $publicatedAt;
	
	public function __construct()
	{
		$this->publicatedAt = new \DateTime('now');
	}
	
	/**
	 * @see Ant\SocialBundle\Model\ProfileInterface::setParticipant()
	 */
	public function setParticipant(ParticipantInterface $participant)
	{
		$this->participant = $participant;
	}
	/**
	 * @see ant\SocialBundle\Model\ProfileInterface::getParticipant()
	 */
	public function getParticipant()
	{
		return $this->participant;
	}
	/**
	 * Set sexualOrientation
	 *
	 * @param string $sexualOrientation
	 * @return Perfil
	 */
	public function setSexualOrientation($sexualOrientation)
	{
		$this->sexualOrientation = $sexualOrientation;
	
		return $this;
	}
	
	/**
	 * Get sexualOrientation
	 *
	 * @return string
	 */
	public function getSexualOrientation()
	{
		return $this->sexualOrientation;
	}
}