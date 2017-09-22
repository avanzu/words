<?php
/**
 * TwigPresenter.php
 * restfully
 * Date: 22.09.17
 */

namespace AppBundle\Presentation;


use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Symfony\Component\HttpFoundation\Response;

class TwigPresenter implements IPresenter
{

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * TwigPresenter constructor.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }


    /**
     * @param TemplateView $view
     *
     * @return string
     */
    public function show(TemplateView $view)
    {
        return $this->twig->render($view->getTemplate(), $view->getParams());
    }
}