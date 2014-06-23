Hooking into the controllers
============================

The controllers packaged with the SocialRestBundle provide a lot of
functionality that is sufficient for general use cases. But, you might find
that you need to extend that functionality and add some logic that suits the
specific needs of your application.

For this purpose, the controllers are dispatching events in many places in
their logic. All events can be found in the constants of the
`Ant\SocialRestBundle\Event\AntSocialRestEvents` class.

All controllers follow the same convention: they dispatch a `SUCCESS` event
when the form is valid before saving the object, and a `COMPLETED` event when
it is done. Thus, all `SUCCESS` events allow you to set a response if you
don't want the default redirection. and all `COMPLETED` events give you access
to the response before it is returned.

Controllers with a form also dispatch an `INITIALIZE` event after the entity is
fetched, but before the form is created.

For instance, this listener will change the redirection after the password
resetting to go to the homepage instead of the profile:

```php

namespace Acme\SocialBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Ant\SocialRestBundle\Event\AntSocialRestEvents;
use Ant\SocialRestBundle\Event\ProfileResponseEvent;
/**
 * Class ControllerListener
 * @package Chatea\SocialBundle\Listener
 */
class ControllerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            AntPhotoRestEvents::PHOTO_SHOW_COMPLETED => 'onPhotoShowCompleted',
            AntPhotoRestEvents::PHOTO_PHOTOS_USER_COMPLETED => 'onPhotoUserCompleted'

        );
    }
    
    /**
     * @param ProfileResponseEvent $event
     */
    public function onProfileShowCompleted(ProfileResponseEvent $event)
    {
        $this->addPublicCacheInResponse($event->getRequest(),$event->getResponse());
    }
    
    private function addPublicCacheInResponse(Request $request, Response $response)
    {
        if($request->getMethod() != 'GET' ){
            return $response;
        }

        $matches    = array();
        $controller = $request->attributes->get('_controller');

        preg_match('/(.*)Bundle\\\Controller\\\(.*)Controller::(.*)Action/', $controller, $matches);

        $parameter =  strtolower(str_replace("\\",'_',$matches[1])).'_bundle'.'.' .strtolower($matches[2]).'_controller' .'.'.strtolower($matches[3]);

        $response->setSharedMaxAge($this->getParameter($parameter));
    }

   
    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string $type The resource type
     *
     * @return Boolean true if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }

    public function getParameter($name)
    {
        if (!$name || !array_key_exists($name, $this->parameters)) {
            throw new ParameterNotFoundException($name);
         }
        return $this->parameters[$name];
    }
}

```


```
// src/Acme/UserBundle/Resources/config/services.yml
parameters:
social_bundle.listener.controller_listener.class: Acme\AcmeBundle\Listener\ControllerListener

services:
    social_bundle.listener.controller_listener:
        class: %social_bundle.listener.controller_listener.class%
        arguments: [%kernel.root_dir%, 'config/cache_times.yml']
        tags:
          - { name: kernel.event_subscriber }
```