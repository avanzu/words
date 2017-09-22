<?php
/**
 * IPresenter.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Infrastructure\Presentation;


interface IPresenter
{
    /**
     * @param TemplateView $view
     *
     * @return string
     */
    public function show(TemplateView $view);

}