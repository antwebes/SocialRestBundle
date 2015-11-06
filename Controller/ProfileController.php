<?php 

namespace Ant\SocialRestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Chatea\UtilBundle\Controller\BaseRestController;

use Chatea\ApiBundle\Entity\User;

use Ant\SocialRestBundle\Model\ParticipantInterface;
use Ant\SocialRestBundle\FormType\ProfileType;
use Ant\SocialRestBundle\Event\ProfileResponseEvent;
use Ant\SocialRestBundle\Event\AntSocialRestEvents;

/**
 * Profile controller.
 *
 */
class ProfileController extends BaseRestController
{
	/**
	 * Create a new profile entity
	 * @ApiDoc(
	 *  	description="create a profile",
	 *		section="user",
	 *  	input="Ant\SocialRestBundle\FormType\ProfileType",
	 *  	output="Ant\SocialRestBundle\Model\Profile",
	 *		statusCodes={
	 *         201="New entity created",
	 *         400="Bad request"
	 *     }
	 *  )
	 * @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 *  
	 */
	public function createAction(User $user, Request $request)
	{
        if ($user->getProfile()) {
			return $this->serviceError('profile.user.exist', '409');
		}
		$profileManager = $this->get('ant.social_rest.manager.profile');
		$profile = $profileManager->createProfile();
		
		$form = $this->get('ant.social_rest.form_factory.profile')->createForm($profile);
		
		//TODO con un handler como para canales
		//Esto es para quitar los campos extra, que puedan venir antes de enviarselo al formulario
		$data = $request->request->get('social_profile');
		
		if ($data != null){
			$children = $form->all();
			$data = array_intersect_key($data, $children);
			
			$form->setData($profile);
			$form->submit($data);
			
			if ($form->isValid()) {
				$profileManager->save($user, $profile);
			
				return $this->buildView($profile, 201, 'profile_show');
			}
			return $this->buildFormErrorsView($form);
		}else{
			return $this->createError('The profile can not be empty', '75', '404');
		}
		
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
	public function showAction(Request $request, ParticipantInterface $user)
	{
		$userVoyeur = $this->container->get('security.context')->getToken()->getUser();
		if (!$user->getProfile()) return $this->buildView(array(), 200);

		//find the profile, increment and create a visit
		$profile = $this->get('ant.social_rest.manager.profile')->show($user->getProfile(), $user, $userVoyeur);
		
		$response = $this->buildView($profile, 200, 'profile_show');
		
		$this->getEventDispatcher()->dispatch(AntSocialRestEvents::PROFILE_SHOW_COMPLETED, new ProfileResponseEvent($user, $profile, $request, $response));
		
		return $response;
	}

	/**
	 * Increment visit counter of profile
	 *
	 *  @ApiDoc(
	 *  	description="increments visits counter",
	 *  	section="user",
	 *  	output="Ant\SocialRestBundle\Model\Profile",
	 *		statusCodes={
	 *         200="Returned when successful",
	 *         404="Unable to find Profile entity with code 42"
	 *     }
	 *  )
	 *
	 *  @ParamConverter("user", class="ApiBundle:User", options={"error" = "user.entity.unable_find"})
	 */
	public function addVisitAction(Request $request, ParticipantInterface $user)
	{
		$profile = $user->getProfile();

		if(!$profile){
			return $this->buildView(array(), 404);
		}

		$this->get('ant.social_rest.manager.profile')->addVisit($profile);

		$response = $this->buildView($profile, 200, 'profile_show');

		$this->getEventDispatcher()->dispatch(AntSocialRestEvents::PROFILE_SHOW_COMPLETED, new ProfileResponseEvent($user, $profile, $request, $response));

		return $response;
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
		$profileActual = $user->getProfile();
		if (!$profileActual) return $this->createError('Unable to find Profile entity', '42', '404');
		
		$data = $request->request->get('social_profile');
		if (!$data) return $this->serviceError('invalid_request', 400);
		
		$editForm = $this->get('ant.social_rest.form_factory.profile')->createForm($profileActual);
		//Esto es para quitar los campos extra, que puedan venir antes de enviarselo al formulario
		$children = $editForm->all();
		$data = array_intersect_key($data, $children);
		
		$data = ($request->getMethod() !== 'PATCH') ? $data : $request->request->get('social_profile');
		
		$editForm->submit($data, 'PATCH' !== $request->getMethod());
		
		if ($editForm->isValid()) {
			try{
				$profileNew = $editForm->getData();
				$this->get('ant.social_rest.manager.profile')->update($profileNew);
			}catch(BadRequestHttpException $e){
				return $this->serviceError($e->getMessage(), '400');
			}
			
			$response = $this->buildView($profileNew, 200, 'profile_show');
			
			$this->getEventDispatcher()->dispatch(AntSocialRestEvents::PROFILE_UPDATE_COMPLETED, new ProfileResponseEvent($user, $profileNew, $request, $response));
			
			return $response;
		}
		return $this->buildFormErrorsView($editForm);
	}
	
	protected function getEventDispatcher()
	{
		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		return $this->container->get('event_dispatcher');
	}
}
