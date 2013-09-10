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
}