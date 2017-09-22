<?php
/**
 * TemplateAware.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Controller;


interface ITemplateAware
{
    public function setTemplate($name);

    public function getTemplate();

}