<?php
/**
 * ProfileController.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Controller;


use AppBundle\Form\PutProfileRequestType;
use AppBundle\Presentation\ResultFlashBuilder;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\InteractiveTrait;
use AppBundle\Traits\RedirectingTrait;
use AppBundle\Traits\TemplateAware;
use Components\Infrastructure\ICommandBus;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Interaction\Users\GetProfile\GetProfileRequest;
use Components\Interaction\Users\GetProfile\GetProfileResponse;
use Components\Interaction\Users\PutProfile\PutProfileRequest;
use Components\Localization\ILocalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ProfileController
 */
class ProfileController extends AbstractController implements ITemplateAware, IFlashing, IRedirectAware
{
    use TemplateAware,
        Flasher,
        InteractiveTrait,
        RedirectingTrait;

    /**
     * @var IPresenter
     */
    protected $presenter;

    /**
     * @var  ILocalizer
     */
    protected $localizer;

    /**
     * @var ICommandBus
     */
    protected $commandBus;

    /**
     * HomeController constructor.
     *
     * @param IPresenter         $presenter
     * @param ILocalizer         $localizer
     * @param ICommandBus        $commandBus
     * @param ResultFlashBuilder $flasher
     */
    public function __construct(
        IPresenter $presenter,
        ILocalizer $localizer,
        ICommandBus $commandBus,
        ResultFlashBuilder $flasher
    ) {
        $this->presenter      = $presenter;
        $this->localizer      = $localizer;
        $this->commandBus     = $commandBus;
        $this->flasher        = $flasher;
    }

    /**
     * @param UserInterface|null $user
     * @param Request            $request
     *
     * @return Response
     */
    public function indexAction(UserInterface $user = null, Request $request)
    {
        if( ! $user ) throw $this->createNotFoundException();
        $command = new GetProfileRequest($user);
        $result  = $this->commandBus->execute($command);

        return $this->createResponse(new ViewHandlerTemplate($this->getTemplate(), $request, ['result' => $result]));
    }

    /**
     * @param UserInterface|null $user
     * @param Request            $request
     *
     * @return Response
     */
    public function updateAction(UserInterface $user = null, Request $request) {

        if( ! $user ) throw $this->createNotFoundException();
        $command = new PutProfileRequest($user->getProfile());
        $form    = $this->createForm(PutProfileRequestType::class, $command, ['method' => 'PUT']);
        $result  = $this->getInteractionResponse($form, $request, $command);


        if( $response = $this->createSuccessResponse($result, $request)){
            return $response;
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $result],
                $result->getStatus()
            ));

    }


    /**
     * @param TemplateView $view
     *
     * @return Response
     */
    protected function createResponse(TemplateView $view)
    {
        $result = $this->presenter->show($view);
        return  $result instanceof Response ? $result : new Response($result);
    }

}