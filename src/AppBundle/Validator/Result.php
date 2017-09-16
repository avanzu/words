<?php
/**
 * Result.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Validator;
use Components\Resource\Validator as Component;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Result implements Component\Result
{

    /**
     * @var ConstraintViolationListInterface
     */
    protected $violations = null;

    /**
     * Result constructor.
     *
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct($violations) {
        $this->violations = $violations;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return !count($this->violations);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }


}