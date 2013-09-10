<?php

namespace Ant\SocialRestBundle\Event;

/**
* Declares all events thrown in the SocialRestBundle
*/
final class AntSocialRestEvents
{
    /**
	* The PROFILE_CREATED event occurs after an user created an profile
	* The event is an instance of Ant\SocialBundle\Event\ProfileEvent
	*
	* @var string
	*/
    const PROFILE_CREATED = 'ant_social_rest.profile_created';
   

}