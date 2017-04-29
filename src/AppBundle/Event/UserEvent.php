<?php
/**
 * UserEvent.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Event;


use AppBundle\Manager\UserManager;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $intent;

    /**
     * UserEvent constructor.
     *
     * @param $model
     * @param $intent
     */
    public function __construct($model, $intent = null)
    {
        $this->model  = $model;
        $this->intent = $intent;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getIntent()
    {
        return $this->intent;
    }

}