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
     * The PROFILE_UPDATE_COMPLETED event occurs after update a profile and before to send response
     * The event is an instance of Ant\SocialBundle\Event\ProfileResponseEvent
     *
     * @var string
     */
    const PROFILE_UPDATE_COMPLETED = 'ant_social_rest.profile.update.completed';
    
    /**
     * The VISIT_VISITORS_COMPLETED event occurs after get a profile and before to send response
     * The event is an instance of Ant\SocialBundle\Event\VisitorsResponseEvent
     *
     * @var string
     */
    const VISIT_VISITORS_COMPLETED = 'ant_social_rest.visit.visitors_completed';
   
    /**
     * The PRE_PROFILE_DELETE event occurs before the method delete of repository is called
     * The event is an instance of Ant\SocialBundle\Event\ProfileEvent
     *
     * @var string
     */
    const PRE_PROFILE_DELETE = 'ant_social_rest.pre.profile.delete';
    
    /**
     * The POST_PROFILE_DELETE event occurs after the method delete of repository was called
     * The event is an instance of Ant\SocialBundle\Event\ProfileEvent
     *
     * @var string
     */
    const POST_PROFILE_DELETE = 'ant_social_rest.post.profile.delete';

}