<?php 

namespace Ant\SocialRestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Ant\SocialRestBundle\Controller\BaseRestController;
use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\FormType\ProfileType;

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
	 *  @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 *  @SecureParam(name="user", permissions="OWNER,HAS_ROLE_ROLE_ADMIN,HAS_ROLE_APPLICATION")
	 *  
	 */
	public function createAction(User $user, Request $request)
	{
		$profileManager = $this->get('ant.social_rest.manager.profile');
		$profile = $profileManager->createProfile();

		$form = $this->get('ant.social_rest.form_factory.profile')->createForm();
		$form->setData($profile);
		
			$form->bind($request);
				
			if ($form->isValid()) {
	
				$profileManager->save($user, $profile);
				
				return $this->buildView($profile, 200);
			}
			return $this->buildFormErrorsView($form);
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
	 *  @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 */
	public function showAction(ParticipantInterface $user)
	{
		$userVoyeur = $this->container->get('security.context')->getToken()->getUser();
		if (!$user->getProfile()) return $this->createError('Unable to find Profile entity', '42', '404');
		
		//find the profile, increment and create a visit
		$profile = $this->get('ant.social_rest.manager.profile')->show($user->getProfile(), $userVoyeur);
		
		return $this->buildView($profile, 200);
	}
	
	/**
	 * Edits an existing Profile entity.
	 * @ApiDoc(
	 * 	description="Update a profile",
	 * 	section="user",
	 *  input="Ant\SocialRestBundle\FormType\ProfileType",
	 *  output="Profile",
	 *	statusCodes={
	 *  	200="Returned when successful",
	 *  	403="Access denied",
	 *      404="Unable to find Profile entity with code 32"
	 * }
	 *  )
	 * @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 * @SecureParam(name="user", permissions="OWNER,HAS_ROLE_ROLE_ADMIN")
	 */
	public function updateAction(User $user, Request $request)
	{
		$profile = $user->getProfile();
		if (!$profile) return $this->createError('Unable to find Profile entity', '42', '404');
		
		$data = $request->request->get('social_profile');
		if (!$data) return $this->serviceError('invalid_request', 400);
		
		if ('PUT' === $request->getMethod()){
			$editForm = $this->get('ant.social_rest.form_factory.profile')->createForm();
			$editForm->setData($profile);
			$editForm->bind($data);
			 
			if ($editForm->isValid()) {				
				$this->get('ant.social_rest.manager.profile')->update($profile);
				return $this->buildView($profile, 200);
			}
			return $this->buildFormErrorsView($editForm);
		}
		if ('PATCH' === $request->getMethod()){
			
			$editForm = $this->get('ant.social_rest.form_factory.profile')->createForm();
			$editForm->bind($request->request->get('social_profile'));
			
			if ($editForm->isValid()) {
				try{
					$this->get('ant.social_rest.manager.profile')->updatePatch($data, $profile);
				}catch(BadRequestHttpException $e){
					return $this->serviceError($e->getMessage(), '400');
				}
				return $this->buildView($profile, 200);
			}		
			return $this->buildFormErrorsView($editForm);
		}
	}
}