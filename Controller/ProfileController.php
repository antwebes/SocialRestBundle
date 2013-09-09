<?php 

namespace Ant\SocialRestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Ant\SocialRestBundle\Controller\BaseRestController;

use Chatea\ApiBundle\Entity\User;

/**
 * Profile controller.
 *
 */
class ProfileController extends BaseRestController
{
	/**
	 * Create a new profile entity
	 *  @ApiDoc(
	 *  	description="create a profile",
	 *		section="user",
	 *  	input="Ant\SocialRestBundle\FormType\ProfileType",
	 *  	output="Ant\SocialRestBundle\Model\Profile",
	 *		statusCodes={
	 *         201="New entity created",
	 *         400="Bad request"
	 *     }
	 *  )
	 *  @SecureParam(name="user", permissions="OWNER,HAS_ROLE_ROLE_ADMIN,HAS_ROLE_APPLICATION")
	 *  @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 */
	public function createAction(User $user)
	{
		$profileManager = $this->get('ant.social.manager.profile');
		$profile = $profileManager->createProfile();
	
		$form = $this->get('ant.social.form_factory.profile')->createForm();
		$form->setData($profile);
	
		if ($request->isMethod('POST')) {
				
			$form->bind($dataRequest);
				
			if ($form->isValid()) {
	
				$profile->setParticipant($user);
				$profileManager->saveProfile($profile);
				
				return $this->buildView($profile, 200);
			}
			return $this->buildFormErrorsView($form);
		}
		return $this->render(
				'AntSocialRestBundle:Profile:add.html.twig',
				array('form'  => $form->createView())
		);
	}
	/**
	 * Show a profile entity
	 *  @ApiDoc(
	 *  	description="show a profile",
	 *  	section="user",
	 *  	output="Ant\SocialRestBundle\Model\Profile",
	 *		statusCodes={
	 *         200="Returned when successful",
	 *         404="Unable to find Profile entity with code 42"
	 *     }
	 *  )
	 */
	public function showAction($id)
	{
		$profileManager = $this->get('ant.social.manager.profile');
		$profile = $profileManager->findProfileById($id);
	
		if (null === $profile) {
			return $this->createError('Unable to find Profile entity', '42', '404');
		}
		
		$user = $this->container->get('security.context')->getToken()->getUser();
		$this->get('ant.social.manager.visit')->addVisit($profile, $user);
				
		return $this->buildView($profile, 200);
	
	}
}