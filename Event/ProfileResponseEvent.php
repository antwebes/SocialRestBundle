<?php

namespace Ant\SocialRestBundle\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\Model\ProfileInterface;

class ProfileResponseEvent extends ProfileEvent
{
	private $response;
	private $request;
	
	public function __construct(ParticipantInterface $user, ProfileInterface $profile, Request $request, Response $response)
	{
		parent::__construct($user, $profile);
		$this->response = $response;
		$this->request = $request;
	}
	
	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}
	
	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
	
}