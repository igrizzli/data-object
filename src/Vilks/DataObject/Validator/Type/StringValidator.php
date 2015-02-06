<?php
namespace Vilks\DataObject\Validator\Type;

class StringValidator implements TypeValidatorInterface, AliasedTypeValidatorInterface
{
    const NAME = 'string';

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
        return ['str'];
    }

    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        return function ($value) use ($type) {
            return is_string($value);
        };
    }
}