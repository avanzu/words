<?php
/**
 * TemplateView.php
 * audiorama
 * Date: 09.11.17
 */

namespace AppBundle\Presentation;
use Components\Infrastructure\Presentation\IHttpStatusProvider;
use Components\Infrastructure\Presentation\TemplateView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewHandlerTemplate extends TemplateView implements IHttpStatusProvider
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var int
     */
    protected  $httpStatus;

    public function __construct($template, Request $request, array $params, $httpStatus = Response::HTTP_OK) {
        parent::__construct($template, $params);
        $this->request    = $request;
        $this->httpStatus = $httpStatus < 200 ? Response::HTTP_OK : $httpStatus;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

}