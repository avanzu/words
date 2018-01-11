<?php
/**
 * KernelControllerSubscriber.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Controller\ITemplateAware;
use Components\Application\Runtime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelControllerSubscriber implements EventSubscriberInterface
{

    /**
     * @var ProjectResolver
     */
    protected $resolver;
    /**
     * @var Runtime
     */
    private $runtime;

    /**
     * KernelControllerSubscriber constructor.
     *
     * @param ProjectResolver $resolver
     * @param Runtime         $runtime
     */
    public function __construct(ProjectResolver $resolver, Runtime $runtime) {
        $this->resolver = $resolver;
        $this->runtime  = $runtime;
    }


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

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$project = $event->getRequest()->get('project')) {
            return;
        }

        $this->runtime->set('project', $this->resolver->createResolver($project));

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
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::REQUEST    => 'onKernelRequest'
        ];
    }


}