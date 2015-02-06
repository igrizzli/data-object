<?php
namespace Vilks\Data\Validator\Type;

interface AliasedTypeValidatorInterface
{
    /**
     * @return string[]
     */
    public static function getAliases();
}