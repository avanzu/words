<?php
/**
 * Validator.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Validator;
use Components\Resource\Validator as Component;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements Component\IValidator
{

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Validator constructor.
     *
     * @param ValidatorInterface  $validator
     * @param TranslatorInterface $translator
     */
    public function __construct(ValidatorInterface $validator, TranslatorInterface $translator) {
        $this->validator  = $validator;
        $this->translator = $translator;
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
        $violations = $this->validator->validate($subject, $constraints, $groups);
        return new Result($violations, $this->translator);
    }
}