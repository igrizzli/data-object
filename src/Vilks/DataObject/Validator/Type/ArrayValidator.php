<?php
namespace Vilks\DataObject\Validator\Type;

use Vilks\DataObject\Validator\DataObjectValidator;

class ArrayValidator implements TypeValidatorInterface
{
    const NAME = 'array';

    /** @var DataObjectValidator */
    private $objectValidator;

    /**
     * {@inheritDoc}
     */
    public static function getName()
    {
        return self::NAME;
    }

    public function __construct(DataObjectValidator $objectValidator)
    {
        $this->objectValidator = $objectValidator;
    }


    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        if ($subType) {
            $subValidator = $this->objectValidator->getValidationCallback($subType);

            return function ($value) use ($subValidator) {
                if (is_array($value)) {
                    foreach ($value as $subValue) {
                        if (!$subValidator($subValue)) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }

                return true;
            };
        } else {
            return function ($value){
                return is_array($value);
            };
        }
    }
}