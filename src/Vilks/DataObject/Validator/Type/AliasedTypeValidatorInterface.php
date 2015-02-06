<?php
namespace Vilks\DataObject\Validator\Type;

interface AliasedTypeValidatorInterface
{
    /**
     * @return string[]
     */
    public static function getAliases();
}