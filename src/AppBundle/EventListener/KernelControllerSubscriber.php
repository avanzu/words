<?php
/**
 * KernelControllerSubscriber.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Controller\IRedirectAware;
use AppBundle\Controller\ITemplateAware;
use AppBundle\Application\Runtime;
use Components\Infrastructure\Presentation\IPresenter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

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
        $this->configureRedirect($object, $event->getRequest());

    }



    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if( ! $event->isMasterRequest()) return;

        if (!$project = $event->getRequest()->get('project')) {
            return;
        }

        $this->runtime->setProject($this->resolver->createResolver($project));




    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // Don't do anything if it's not the master request.
        if (!$event->isMasterRequest()) {
            return;
        }

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

    /**
     * @param $controller
     * @param $request
     */
    protected function configureRedirect($controller, $request)
    {
        if( ! $controller instanceof IRedirectAware ) {
            return;
        }

        if( $request->attributes->has('_redirect')) {
            $controller->setRedirect($request->attributes->get('_redirect'));
        }
    }


    /** @inheritdoc */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::REQUEST    => 'onKernelRequest',
            KernelEvents::RESPONSE   => 'onKernelResponse'
        ];
    }


}