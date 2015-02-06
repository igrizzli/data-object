<?php
namespace Vilks\DataObject\Validator\Type;

class ObjectValidator implements TypeValidatorInterface
{
    const NAME = 'object';

    /**
     * {@inheritDoc}
     */
    public static function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        if ($type == self::getName()) {
            $type = $subType;
        }

        if(!class_exists($type)) {
            throw new \InvalidArgumentException(sprintf('Class with name %s not exists', $type));
        }

        return function ($value) use ($type) {
            return is_object($value) && $value instanceof $type;
        };
    }
}