<?php
namespace Vilks\Data\Validator\Type;

class BooleanValidator implements TypeValidatorInterface, AliasedTypeValidatorInterface
{
    const NAME = 'boolean';

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
    public static function getAliases()
    {
        return ['bool'];
    }

    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        return function ($value) use ($type) {
            return is_bool($value);
        };
    }
}