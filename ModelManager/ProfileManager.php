<?php 

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Entity\Profile;

use Ant\SocialRestBundle\Model\ParticipantInterface;

use Ant\SocialRestBundle\Model\ProfileInterface;
use Ant\SocialRestBundle\Event\ProfileEvent;
use Ant\SocialRestBundle\Event\AntSocialRestEvents as Events;

abstract class ProfileManager
{
	
	
	public function createProfile()
	{
		$class = $this->getClass();
		$profile = new $class;
	
		return $profile;
	}
	
	public function saveProfile($user, ProfileInterface $profile)
	{
		$this->doSaveProfile($profile);
		
		$profileEvent = new ProfileEvent($user, $profile);
		$this->dispatcher->dispatch(Events::PROFILE_CREATED, $profileEvent);
	}
	
	public function show($id, $userVoyeur)
	{
		$profile = $this->findProfileById($id);
		if ($profile){
			if (!$this->isMyProfile($profile, $userVoyeur)){
				$this->addVisit($profile);
				$this->visitManager->addVisit($profile, $userVoyeur);
			}
		}
		return $profile;		
	}
		
	public function isMyProfile(ProfileInterface $profile, $user)
	{
		return ($profile == $user->getProfile());
	}
	/**
	 * @param string $id
	 * @return ProfileInterface
	 */
	public function findProfileById($id)
	{
		return $this->findOneProfileBy(array('id' => $id));
	}
	
	public function addVisit(ProfileInterface $profile)
	{
		$profile->setVisits($profile->getVisits()+1);
		$this->doSaveProfile($profile);
	}
}