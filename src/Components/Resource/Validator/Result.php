<?php
/**
 * ValidatorResult.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Validator;


interface Result
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