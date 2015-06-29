<?php 

namespace Ant\SocialRestBundle\Controller;

use Ant\SocialRestBundle\Event\VisitorsResponseEvent;
use Ant\SocialRestBundle\Event\AntSocialRestEvents;
use Ant\SocialRestBundle\Model\ParticipantInterface;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use FOS\RestBundle\Controller\Annotations\QueryParam;

use Chatea\UtilBundle\Controller\BaseRestController;

use Chatea\ApiBundle\Entity\User;

class VisitController extends BaseRestController
{
	/**
	 * Show visits of one profile
	 * @ApiDoc(
	 *  description="Show visits of one profile",
	 *  section="user",
	 *  output="Ant\SocialRestBundle\Model\Visit",
	 *	statusCodes={
	 *  	200="Returned when successful",
	 *      404="Unable to find Profile entity with code 42"
	 *    }
	 * )
	 * @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find", "id" = "id"})
	 * @QueryParam(name="limit", description="Max number of records to be returned")
	 * @QueryParam(name="offset", description="Number of records to skip")
	 */
	public function visitorsAction(ParticipantInterface $user, Request $request)
	{
		$orderField = $this->container->getParameter('ant_social_rest.visitors_order.default_field');
		$orderDirection = $this->container->getParameter('ant_social_rest.visitors_order.default_direction');
		$order  = $request->query->get('order', "$orderField=$orderDirection");

		$maxResult = $request->query->get('maxResult');

		$visits = $this->get('ant.social_rest.manager.visit')->findVisitorsOf($user, $maxResult, $order);

		$linkOverrides = array('route' => 'ant_social_rest_profile_visitors', 'parameters' => array('id'), 'rel' => 'self', 'entity' => $user);

		$response = $this->buildPagedResourcesView($visits, 'Ant\SocialRestBundle\Entity\Visit', 200, 'user_list', array(), $linkOverrides);

		$this->getEventDispatcher()->dispatch(AntSocialRestEvents::VISIT_VISITORS_COMPLETED, new VisitorsResponseEvent($user, null, $request, $response, $visits));

		return $response;
	}
	
	protected function getEventDispatcher()
	{
		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		return $this->container->get('event_dispatcher');
	}
}