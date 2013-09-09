<?php

namespace Ant\SocialRestBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use	FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Chatea\UtilBundle\Util\ErrorResponse;
use Chatea\UtilBundle\Util\ErrorsForm;

use JMS\Serializer\SerializationContext;

/**
 * BaseRest Controller.
 *
 */
abstract class BaseRestController extends FOSRestController
{
	
    public function buildView($entity, $statusCode, $context = null)
    {
    	$visit = $this->visit($entity, $statusCode);
    
    	if($context != null){
    		$context = SerializationContext::create()->setGroups(array($context));
    		$visit->setSerializationContext($context);
    	}
    		
    	return $this->handleView($visit);
    }
    
    public function createError($message, $code, $statusCode)
    {
    	$errorResponse = ErrorResponse::createResponse($message, $code);
    	$visit = View::create($errorResponse, $statusCode);
    	return $this->handleView($visit);
    }
    
    protected function createFormErrorsView($form, $statusCode = 400)
    {
    	$errors = ErrorsForm::getAllFormErrorMessages($form);
    	$r = $this->get('api.servicio.error_response')->createResponse($errors, $this->container->getParameter('channel.form.register'));
    	$visit = $this->visit($r, $statusCode);
    	$visit->setFormat('json');
    	return $visit;
    }
    
    protected function buildFormErrorsView($form)
    {
    	$visit = $this->createFormErrorsView($form);
    	return $this->handleView($visit);
    }
}
