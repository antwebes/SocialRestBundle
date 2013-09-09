<?php 

namespace Ant\SocialBundle\ModelManager;

use Ant\SocialBundle\Model\ProfileInterface;

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
	 * @return PhotoInterface
	 */
	public function findProfileById($id)
	{
		return $this->findOneProfileBy(array('id' => $id));
	}
}