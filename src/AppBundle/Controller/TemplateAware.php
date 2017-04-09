<?php
/**
 * TemplateAware.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Controller;


interface TemplateAware
{
    public function setTemplate($name);

    public function getTemplate();

}