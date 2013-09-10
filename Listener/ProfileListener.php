<?php

namespace Ant\SocialRestBundle\Listener;

use Ant\SocialRestBundle\Event\ProfileEvent;

class ProfileListener
{
	private $userManager;
	
	public function __construct($userManager)
	{
		$this->userManager = $userManager;
	}
	
	public function profileCreated(ProfileEvent $profileEvent)
	{
		
		$this->userManager->setProfile($profileEvent->getUser(), $profileEvent->getProfile());
	}
}