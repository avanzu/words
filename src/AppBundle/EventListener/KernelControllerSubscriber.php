<?php
/**
 * KernelControllerSubscriber.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Controller\ITemplateAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelControllerSubscriber implements EventSubscriberInterface
{

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        $object = reset($controller);

        $this->configureTemplate($object, $event->getRequest());

    }

    /**
     * @param $controller
     * @param $request
     */
    protected function configureTemplate($controller, $request)
    {
        if( !$controller instanceof ITemplateAware ) {
            return;
        }

        if( $request->attributes->has('_template') ) {
            $controller->setTemplate($request->attributes->get('_template'));
        }
    }

    /** @inheritdoc */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }


}