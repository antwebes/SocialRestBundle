<?php 

namespace Ant\SocialRestBundle\Model;



abstract class Profile implements ProfileInterface {
		
	protected $id;
	protected $about;
	protected $seeking;
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
	 * Set seeking
	 *
	 * @param string $seeking
	 * @return Perfil
	 */
	public function setSeeking($seeking)
	{
		$this->seeking = $seeking;
	
		return $this;
	}
	
	/**
	 * Get seeking
	 *
	 * @return string
	 */
	public function getSeeking()
	{
		return $this->seeking;
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
	
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
	}
	
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
	
	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}
	
	public function getBirthday()
	{
		return $this->birthday;
	}
}