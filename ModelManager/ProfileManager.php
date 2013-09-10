<?php 

namespace Ant\SocialRestBundle\ModelManager;

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
		//TODO lanzar evento y que el usuario guarde el perfil con un listener
		$profileEvent = new ProfileEvent($user, $profile);
		$this->dispatcher->dispatch(Events::PROFILE_CREATED, $profileEvent);
	}
	
	/**
	 * @param string $id
	 * @return ProfileInterface
	 */
	public function findProfileById($id)
	{
		return $this->findOneProfileBy(array('id' => $id));
	}
}