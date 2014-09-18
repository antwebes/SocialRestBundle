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
}