<?php
/**
 * ResourceController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\ResourceManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResourceController extends Controller
{

    /**
     * @var ResourceManager
     */
    protected $manager;

    /**
     * ResourceController constructor.
     *
     * @param ResourceManager $manager
     */
    public function __construct(ResourceManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @return ResourceManager
     */
    public function getManager()
    {
        return $this->manager;
    }


    /**
     * @param Request $request
     * @param Form    $form
     * @param         $model
     *
     * @return bool
     */
    protected function handleForm(Request $request, Form $form, $model, $intent = null)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return false;
        }

        if( ! $form->isValid() ) {
            return false;
        }

        $this->preSaveModel($model, $request, $intent);

        $this->getManager()->save($model, true, $intent);

        $this->postSaveModel($model, $request, $intent);

        return true;
    }

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function preSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function postSaveModel($model, Request $request, $intent = null)
    {}


}