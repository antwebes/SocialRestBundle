<?php 

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\Entity\Profile;

use Ant\SocialRestBundle\Model\ParticipantInterface;

use Ant\SocialRestBundle\Model\ProfileInterface;
use Ant\SocialRestBundle\Event\ProfileEvent;
use Ant\SocialRestBundle\Event\AntSocialRestEvents as Events;

use Doctrine\Common\Util\Inflector as Inflector;

abstract class ProfileManager
{	
	public function createProfile()
	{
		$class = $this->getClass();
		$profile = new $class;
	
		return $profile;
	}
	
	public function save($user, ProfileInterface $profile)
	{
		$this->doSave($profile);
		
		$profileEvent = new ProfileEvent($user, $profile);
		$this->dispatcher->dispatch(Events::PROFILE_CREATED, $profileEvent);
	}
	
	public function show(ProfileInterface $profile, ParticipantInterface $user, ParticipantInterface $userVoyeur = null)
	{
		if(!($user == $userVoyeur)){
			//add visit to profile
			$this->addVisit($profile);
			
			if($userVoyeur){
				//create the object visit
				$this->visitManager->addVisit($user, $userVoyeur);
			}
		}
		
		return $profile;		
	}
		
	public function isMyProfile(ProfileInterface $profile, ParticipantInterface $user)
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
		$profile->setCountVisits($profile->getCountVisits()+1);
		$this->doSave($profile);
	}
	
	public function updatePatch($data, ProfileInterface $profile)
	{
		if ($data) {
			foreach ($data as $key => $value) {
				$key = Inflector::camelize($key);
				$method = 'set'. ucfirst($key);
		
				if(!method_exists($profile, $method)) throw new BadRequestHttpException('invalid_request');
				call_user_func_array(array($profile, $method), array($value));
			}
			$this->doSave($profile);
		}
	}
	
	public function update($entity)
	{
		$this->doSave($entity);
	}
}