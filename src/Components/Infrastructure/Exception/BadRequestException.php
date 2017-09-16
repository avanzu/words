<?php
/**
 * BadRequestException.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Exception;


use Components\Infrastructure\Response\ValidationFailedResponse;

class BadRequestException extends ValidationFailedResponse
{
}