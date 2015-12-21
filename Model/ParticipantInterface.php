<?php

namespace Ant\SocialRestBundle\Model;

/**
 * User owner of a profile
 * May be implemented by a FOS\UserBundle user document or entity.
 * Or anything you use to represent users in the application.
 *
 * @author Pablo <pablo@antweb.es>
 */
interface ParticipantInterface
{
    /**
     * Gets the unique identifier of the winner
     *
     * @return string
     */
  //  function getId();

    /**
     * Returns a profile
     *
     * @return ProfileInterface
     */
    public function getProfile();
}
