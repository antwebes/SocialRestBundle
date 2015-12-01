<?php 

namespace Ant\SocialRestBundle\Model;


interface ProfileInterface{
		
	public function setSeeking($seeking);
	
	public function getSeeking();
	
	public function setCountVisits($countVisits);
	
	public function getCountVisits();

    public function setUpdatedAt($updatedAt);
    
    public function getUpdatedAt();

    public function setBirthday($birthday);
    
    public function getBirthday();

    public function setRelationshipStatus($relationshipStatus);
    public function getRelationshipStatus();

    public function setInterests($interests);
    public function getInterests();
    public function addInterest($interest);
    public function hasInterest($interest);
    public function removeInterest($interest);
}