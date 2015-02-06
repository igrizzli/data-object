<?php
namespace Vilks\DataObject\Validator\Type;

class DoubleValidator implements TypeValidatorInterface, AliasedTypeValidatorInterface
{
    const NAME = 'double';

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
        return ['float'];
    }

    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        return function ($value) use ($type) {
            return is_double($value);
        };
    }
}