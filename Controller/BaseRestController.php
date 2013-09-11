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
    	$view = $this->view($entity, $statusCode);
    
    	if($context != null){
    		$context = SerializationContext::create()->setGroups(array($context));
    		$view->setSerializationContext($context);
    	}
    		
    	return $this->handleView($view);
    }
    
    public function createError($message, $code, $statusCode)
    {
    	$errorResponse = ErrorResponse::createResponse($message, $code);
    	$view = View::create($errorResponse, $statusCode);
    	return $this->handleView($view);
    }
    
    protected function createFormErrorsView($form, $statusCode = 400)
    {
    	$errors = ErrorsForm::getAllFormErrorMessages($form);
    	$r = $this->get('api.servicio.error_response')->createResponse($errors, $this->container->getParameter('channel.form.register'));
    	$view = $this->view($r, $statusCode);
    	$view->setFormat('json');
    	return $view;
    }
    
    protected function serviceError($serviceError, $status)
    {
    	$codeLoader = $this->get('api.servicio.code_loader');
    	$error = $codeLoader->load()[$serviceError];
    	$errorResponse = ErrorResponse::createResponse($error['message'], $error['code']);
    	$view = View::create($errorResponse, $status);
    	return $this->handleView($view);
    }
    
    protected function buildFormErrorsView($form)
    {
    	$view = $this->createFormErrorsView($form);
    	return $this->handleView($view);
    }
}
