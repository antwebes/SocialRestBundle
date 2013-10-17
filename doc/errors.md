###Service Error
return $this->serviceError('profile.user.exist', '409');

i.e. The service "serviceError" receive two parameters. First the code of the error in the file: codes.yml, which has two fields, a message and a code our.
The second parameter, is a code http of the error.
