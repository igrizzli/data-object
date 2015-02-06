<?php
namespace Vilks\Data\Validator\Type;

interface TypeValidatorInterface
{
    /**
     * @return string
     */
    public static function getName();

    /**
     * @param string $type
     * @param string $subType
     *
     * @return callable
     */
    public function getCallback($type, $subType);
}