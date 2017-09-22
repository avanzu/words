<?php
/**
 * ValidatorResult.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Validator;


interface IResult
{
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return mixed
     */
    public function getViolations();

    /**
     * @return array
     */
    public function getMessages();
}