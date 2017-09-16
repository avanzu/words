<?php
/**
 * Validator.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Validator;
use Components\Resource\Validator as Component;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements Component\Validator
{

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Validator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator) {
        $this->validator = $validator;
    }

    /**
     * @param mixed $subject
     * @param null  $constraints
     * @param null  $groups
     *
     * @return Result
     */
    public function validate($subject, $constraints= null, $groups = null)
    {
        return new Result(
            $this->validator->validate($subject, $constraints, $groups)
        );
    }
}