<?php 

namespace Ant\SocialRestBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

abstract class Profile implements ProfileInterface {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Assert\Length(
	 * 	max = "600")
	 */
	protected $about;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\Choice(
	 * choices = {"heterosexual", "homosexual", "bisexual"},
	 * message = "profile.sexualOrientation.choice"
	 * )
	 */
	protected $sexualOrientation;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\Choice(
	 * choices = {"hombre", "mujer", "otro"},
	 * message = "profile.gender.choice"
	 * )
	 */
	protected $gender;
	
	/**
	 * @var date $birthday
	 *
	 * @ORM\Column(name="birthday", type="date", nullable=true)
	 */
	protected $birthday;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $countVisits=0;
	
	/**
	 * 
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $youWant;
	
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
	
	public function setAbout($about)
	{
		$this->about = $about;
		
	}
	
	public function getAbout()
	{
		return $this->about;
	}
	
	public function setCountVisits($countVisits)
	{
		$this->countVisits = $countVisits;
	}
	
	public function getCountVisits()
	{
		return $this->countVisits;
	}
}