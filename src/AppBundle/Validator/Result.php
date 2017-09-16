<?php
/**
 * Result.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Validator;
use Components\Resource\Validator as Component;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class Result implements Component\Result
{

    /**
     * @var ConstraintViolationListInterface
     */
    protected $violations = null;
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Result constructor.
     *
     * @param ConstraintViolationListInterface $violations
     * @param TranslatorInterface              $translator
     */
    public function __construct($violations, TranslatorInterface $translator) {
        $this->violations = $violations;
        $this->translator = $translator;
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

    /**
     * @return array
     */
    public function getMessages()
    {
        $messages = [];
        /** @var ConstraintViolationInterface $violation */
        foreach($this->violations as $violation) {
            list($prop, $message) = $this->getMessageTranslated($violation);
            isset($messages[$prop]) or $messages[$prop] = [];
            $messages[$prop][] = $message;
        }

        return $messages;
    }

    protected function getMessageTranslated(ConstraintViolationInterface $violation)
    {
        $translator = $this->translator;
        $property   = $translator->trans($violation->getPropertyPath());

        if( $violation->getPlural() ) {
            $message = $translator->transChoice($violation->getMessageTemplate(), $violation->getPlural(), $violation->getParameters(), 'validators');
        } else {
            $message = $translator->trans($violation->getMessageTemplate(), $violation->getParameters(), 'validators');
        }

        return [$property, $message];
    }

}