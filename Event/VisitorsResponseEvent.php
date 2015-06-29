<?php

namespace Ant\SocialRestBundle\Event;

use Doctrine\ORM\Tools\Pagination\Paginator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\Model\ProfileInterface;

class VisitorsResponseEvent extends ProfileEvent
{
	private $response;
	private $request;
	private $visits;
	
	public function __construct(ParticipantInterface $user, ProfileInterface $profile = null, Request $request, Response $response, Paginator $visits)
	{
		parent::__construct($user, $profile);
		$this->response = $response;
		$this->request = $request;
		$this->visits = $visits;
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
	
	public function getVisits()
	{
		return $this->visits;
	}
	
}