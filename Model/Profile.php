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
	protected $relationshipStatus;
	protected $interests;
	

	public function __construct()
	{
		$this->publicatedAt = new \DateTime('now');
		$this->interests = array();
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
	
	public function setRelationshipStatus($relationshipStatus)
	{
		$this->relationshipStatus = $relationshipStatus;
	}
	
	public function getRelationshipStatus()
	{
		return $this->relationshipStatus;
	}

    /**
     * Returns the user interests
     *
     * @return array The interests
     */
    public function getInterests()
    {
        $interests = $this->interests;
        if (!is_array($interests)){
        	$interests[] = 'default';
        }
        return array_unique($interests);
    }

    public function setInterests($interests)
    {
        $this->interests = array();
        foreach ($interests as $interest) {
            $this->addInterest($interest);
        }

        return $this;
    }

    public function addInterest($interest)
    {
        $interest = strtolower($interest);

        if (!in_array($interest, $this->getInterests(), true)) {
            $this->interests[] = $interest;
        }

        return $this;
    }

    /**
     * @param string $interest
     *
     * @return boolean
     */
    public function hasInterest($interest)
    {
        return in_array(strtolower($interest), $this->getInterests(), true);
    }

    public function removeInterest($interest)
    {
        if (false !== $key = array_search(strtolower($interest), $this->getInterests(), true)) {
            unset($this->interests[$key]);
            $this->interests = array_values($this->getInterests());
        }

        return $this;
    }
}