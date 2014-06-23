<?php 

namespace Ant\SocialRestBundle\Model;


interface ProfileInterface{
		
	public function setSexualOrientation($sexualOrientation);
	
	public function getSexualOrientation();
	
	public function setCountVisits($countVisits);
	
	public function getCountVisits();

    public function setUpdatedAt($updatedAt);
    
    public function getUpdatedAt();

    public function setBirthday($birthday);
    
    public function getBirthday();
}