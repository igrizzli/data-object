<?php
namespace Vilks\DataObject\Validator\Type;

use Vilks\DataObject\DataObjectCollection;

class CollectionValidator implements TypeValidatorInterface
{
    const NAME = 'collection';

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
        if ($subType) {
            if(!class_exists($subType)) {
                throw new \InvalidArgumentException(sprintf('Class with name %s not exists', $type));
            }
            return function ($value) use ($subType) {
                return $value instanceof DataObjectCollection && $subType == $value->getType();
            };
        } else {
            return function ($value){
                return $value instanceof DataObjectCollection;
            };
        }
    }
}