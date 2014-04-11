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
    
    /**
     * The PROFILE_SHOW_COMPLETED event occurs after get a profile and before to send response
     * The event is an instance of Ant\SocialBundle\Event\ProfileResponseEvent
     *
     * @var string
     */
    const PROFILE_SHOW_COMPLETED = 'ant_social_rest.profile.show_completed';
    
    /**
     * The VISIT_VISITORS_COMPLETED event occurs after get a profile and before to send response
     * The event is an instance of Ant\SocialBundle\Event\VisitorsResponseEvent
     *
     * @var string
     */
    const VISIT_VISITORS_COMPLETED = 'ant_social_rest.visit.visitors_completed';
   

}