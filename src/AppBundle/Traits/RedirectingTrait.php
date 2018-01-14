<?php
/**
 * RedirectingTrait.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Traits;


trait RedirectingTrait
{
    protected $redirect = false;

    public function setRedirect($name) {
        $this->redirect = $name;
    }

    public function getRedirect()
    {
        return $this->redirect;
    }


}