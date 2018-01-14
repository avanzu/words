<?php
/**
 * IRedirectAware.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Controller;


interface IRedirectAware
{
    /**
     * @param       $name
     * @return $this
     */
    public function setRedirect($name);
}