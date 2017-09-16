<?php
/**
 * Validator.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Validator;


interface Validator
{
    /**
     * @param mixed $subject
     * @param null  $constraints
     * @param null  $groups
     *
     * @return Result
     */
    public function validate($subject, $constraints= null, $groups = null);
}