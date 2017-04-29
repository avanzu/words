<?php
/**
 * TemplateAware.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Traits;


trait TemplateAware
{

    protected $template;

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

}