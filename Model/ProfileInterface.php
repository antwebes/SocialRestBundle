<?php 

namespace Ant\SocialRestBundle\Model;


interface ProfileInterface{
		
	public function setSexualOrientation($sexualOrientation);
	
	public function getSexualOrientation();
	
	public function setVisits($visits);
	
	public function getVisits();
}