<?php
/**
 * IHttpStatusProvider.php
 * words
 * Date: 08.02.18
 */

namespace Components\Infrastructure\Presentation;


interface IHttpStatusProvider
{
    /**
     * @return int
     */
    public function getHttpStatus();
}