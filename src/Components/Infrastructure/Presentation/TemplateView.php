<?php
/**
 * TemplateView.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Infrastructure\Presentation;


class TemplateView
{
    protected $template;

    protected $params = [];

    /**
     * TemplateView constructor.
     *
     * @param       $template
     * @param array $params
     */
    public function __construct($template, array $params)
    {
        $this->template = $template;
        $this->params   = $params;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    public function only($name) {
        if( isset($this->params[$name])) return $this->params[$name];
        return null;
    }


    public function pick(...$names)
    {
        return array_intersect_key(array_flip($names), $this->params);
    }

}