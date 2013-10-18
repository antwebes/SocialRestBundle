<?php 

namespace Ant\SocialRestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use FOS\RestBundle\Controller\Annotations\QueryParam;

use Chatea\UtilBundle\Controller\BaseRestController;
use Ant\SocialRestBundle\Model\ParticipantInterface;

use Chatea\ApiBundle\Entity\User;
use Chatea\SocialBundle\Entity\Visit;

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
		$profile = $user->getProfile();
		if (!$profile) return $this->createError('Unable to find Profile entity', '42', '404');

		$maxResult = $request->query->get('maxResult');
// 		ldd($request->query->get('maxResult'));
		$visits = $this->get('ant.social_rest.manager.visit')->findVisitorsOf($user, $maxResult);

		return $this->buildPagedView($visits, $user, 'ant_social_rest_profile_visitors', 200, 'list');
	}

	private function buildPagedView($collection, $entity, $route, $statusCode, $contextGroup = null)
	{
		$overrides = array(
			                array(
							    'rel' => 'self', 
							    'definition' => array('route' => $route, 'parameters' => array('id'), 'rel' => 'self'), 
								'data' => $entity
						    )
					      );

		return $this->buildPagedResourcesView(
            $collection, 
            'Ant\SocialRestBundle\Entity\Visit', 
            $statusCode, 
            $contextGroup, 
            array(), 
            $overrides
            );
	}
}