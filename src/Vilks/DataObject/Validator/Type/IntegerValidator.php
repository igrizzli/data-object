<?php
namespace Vilks\DataObject\Validator\Type;

class IntegerValidator implements TypeValidatorInterface, AliasedTypeValidatorInterface
{
    const NAME = 'integer';

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
        return ['int'];
    }


    /**
     * {@inheritDoc}
     */
    public function getCallback($type, $subType = null)
    {
        return function ($value) use ($type) {
            return is_integer($value);
        };
    }
}