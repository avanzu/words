<?php
/**
 * JsonPresenter.php
 * words
 * Date: 08.02.18
 */

namespace AppBundle\Presentation;


use Components\Infrastructure\Presentation\IHttpStatusProvider;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class JsonPresenter implements IPresenter
{

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * JsonPresenter constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }


    /**
     * @param IHttpStatusProvider|TemplateView $view
     *
     * @return string
     */
    public function show(TemplateView $view)
    {
        $response = new Response(
            $this->serializer->serialize($view->only('result'), 'json'),
            $view->getHttpStatus(),
            ['Content-Type' => 'application/json']
        );

        return $response;
    }
}