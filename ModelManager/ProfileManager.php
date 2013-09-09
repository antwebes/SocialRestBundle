<?php 

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Model\ProfileInterface;

abstract class ProfileManager
{
	public function createProfile()
	{
		$class = $this->getClass();
		$profile = new $class;
	
		return $profile;
	}
	
	public function saveProfile(ProfileInterface $profile)
	{
		$this->doSaveProfile($profile);
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