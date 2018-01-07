<?php
/**
 * ViewHandlerPresenter.php
 * audiorama
 * Date: 09.11.17
 */

namespace AppBundle\Presentation;


use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;

class ViewHandlerPresenter implements IPresenter
{

    /**
     * @var ViewHandler
     */
    protected $viewHandler;

    /**
     * ViewHandlerPresenter constructor.
     *
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler) {
        $this->viewHandler = $viewHandler;
    }


    /**
     * @param Request $request
     *
     * @return string
     */
    protected function getResponseFormat(Request $request)
    {
        $formats = array_map(
            function ($list) {
                $_ = explode('/', $list);

                return end($_);
            },
            $request->getAcceptableContentTypes()
        );

        if ($format = $request->get('_format')) {
            array_unshift($formats, $format);
        }

        foreach ($formats as $format) {
            if ($this->viewHandler->supports($format)) {
                return $format;
            }
        }

        return 'html';
    }

    /**
     * @param TemplateView|ViewHandlerTemplate $templateView
     *
     * @return string
     */
    public function show(TemplateView $templateView)
    {

        $view = View::create($templateView->getParams())
                    ->setFormat($this->getResponseFormat($templateView->getRequest()))
                  ->setTemplate($templateView->getTemplate())
        ;
        return $this->viewHandler->handle($view)->setStatusCode($templateView->getHttpStatus());



    }
}