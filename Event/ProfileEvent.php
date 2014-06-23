<?php

namespace Ant\SocialRestBundle\Event;

use Ant\SocialRestBundle\Model\ProfileInterface;

use Symfony\Component\EventDispatcher\Event;

class ProfileEvent extends Event
{
	private $profile;
	private $user;
	
	public function __construct($user, ProfileInterface $profile)
	{
		$this->profile = $profile;
		$this->user = $user;
	}
	
	public function getProfile()
	{
		return $this->profile;
	}
	public function getUser()
	{
		return $this->user;
	}
}