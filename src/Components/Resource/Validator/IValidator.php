<?php
/**
 * Validator.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Validator;


interface IValidator
{
    /**
     * @param mixed $subject
     * @param null  $constraints
     * @param null  $groups
     *
     * @return IResult
     */
    public function validate($subject, $constraints= null, $groups = null);
}