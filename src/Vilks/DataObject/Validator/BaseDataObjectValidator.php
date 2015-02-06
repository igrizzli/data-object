<?php
namespace Vilks\DataObject\Validator;

use Vilks\DataObject\Validator\Type\AliasedTypeValidatorInterface;
use Vilks\DataObject\Validator\Type\TypeValidatorInterface;

class BaseDataObjectValidator implements DataObjectValidator
{
    private $typeAliases = [];
    /** @var TypeValidatorInterface[] */
    private $typeValidators = [];
    /** @var TypeValidatorInterface */
    private $fallbackValidator;

    public function __construct()
    {
        $this->fallbackValidator = new Type\ObjectValidator;
        $this->addTypeValidator(new Type\IntegerValidator)
            ->addTypeValidator(new Type\StringValidator)
            ->addTypeValidator(new Type\DoubleValidator)
            ->addTypeValidator(new Type\BooleanValidator)
            ->addTypeValidator(new Type\ArrayValidator($this))
            ->addTypeValidator(new Type\CollectionValidator)
            ->addTypeValidator($this->fallbackValidator);
    }

    /**
     * @param TypeValidatorInterface $validator
     *
     * @return self
     */
    public function addTypeValidator(TypeValidatorInterface $validator)
    {
        $name = $validator::getName();
        $this->typeValidators[$name] = $validator;

        if ($validator instanceof AliasedTypeValidatorInterface) {
            foreach ($validator->getAliases() as $alias) {
                $this->typeAliases[$alias] = $name;
            }
        }

        return $this;
    }

    /**
     * @param string $typeString
     *
     * @return callable
     * @throws \InvalidArgumentException
     */
    public function getValidationCallback($typeString = null)
    {
        if (is_null($typeString)) {
            return null;
        }

        $typeString = trim($typeString);
        $position = strpos($typeString, '<');
        if ($position !== false) {
            $type = trim(substr($typeString, 0, $position));
            $subType = trim(substr($typeString, $position+1, strlen($typeString)-$position-2));
        } else {
            $type = $typeString;
            $subType = null;
        }
        if (array_key_exists($type, $this->typeAliases)) {
            $type = $this->typeAliases[$type];
        }
        if(array_key_exists($type, $this->typeValidators)) {
            return $this->typeValidators[$type]->getCallback($type, $subType);
        } else {
            return $this->fallbackValidator->getCallback($type, $subType);
        }
    }
}