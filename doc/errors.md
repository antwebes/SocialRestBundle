###Service Error
>return $this->serviceError('profile.user.exist', '409');

i.e. The service "serviceError" receive two parameters. First the code of the error in the file: codes.yml, which has two fields, a message and a code our.
The second parameter, is a code http of the error.

This service has the code: 
```
	$codeLoader = $this->get('api.servicio.code_loader');
    $error = $codeLoader->load()[$serviceError];
    $errorResponse = ErrorResponse::createResponse($error['message'], $error['code']);
    $view = View::create($errorResponse, $status);
    return $this->handleView($view);
```
So, use the fosRestBundle to show the response