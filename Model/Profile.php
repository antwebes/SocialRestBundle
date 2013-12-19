<?php 

namespace Ant\SocialRestBundle\Model;



abstract class Profile implements ProfileInterface {
		
	protected $id;
	protected $about;
	protected $sexualOrientation;
	protected $gender;
	protected $birthday;
	protected $countVisits=0;
	protected $youWant;
	protected $updatedAt;
	protected $publicatedAt;
	protected $profilePhoto;
	
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