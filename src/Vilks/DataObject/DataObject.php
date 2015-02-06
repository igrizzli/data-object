<?php
namespace Vilks\DataObject;

use Vilks\DataObject\Exception\DirectPropertySetException;
use Vilks\DataObject\Exception\PropertyNotFoundException;
use Vilks\DataObject\Exception\PropertyValidationFailedException;
use Vilks\DataObject\Exception\WrongEvolutionInheritanceException;
use Vilks\DataObject\Validator\DataObjectValidatorFactory;

/**
 * Base DataObject
 *
 * @package Vilks\DataObject
 */
abstract class DataObject
{
    private static $validators = [];

    /**
     * Create instance of DataObject
     *
     * @return static
     */
    public static function create()
    {
        return new static;
    }

    /**
     * Create instance of DataObject with values based on related DataObject
     *
     * @param DataObject $source Data source object
     *
     * @return static
     * @throws Exception\WrongEvolutionInheritanceException If DataObjects has different chain of inheritance
     */
    public static function mutate(DataObject $source)
    {
        $replica = static::create();
        if ($replica instanceof $source) {
            $properties = get_object_vars($source);
        } elseif ($source instanceof $replica) {
            $properties = get_object_vars($replica);
        } else {
            throw new WrongEvolutionInheritanceException(
                $replica,
                $source,
                sprintf('Class "%s" must be parent or child for "%s"', get_class($source), get_class($replica))
            );
        }

        foreach ($properties as $name => $value) {
            $replica->$name = $value;
        }

        return $replica;
    }

    /**
     * Magic set property of DataObject
     *
     * IMPORTANT: For better performance in production you need
     * to overwrite method for each property in final DataObjects
     *
     * @param string $name
     * @param array $arguments
     *
     * @return static
     */
    public function __call($name, array $arguments)
    {
        $this->_isPropertyExists($name);
        if (!count($arguments)) {
            return $this->$name;
        } else {
            $value = $arguments[0];
            $this->_validateDataType($name, $value);

            $replica = static::_isMutable() ? $this : clone $this;
            $replica->$name = $value;

            return $replica;
        }
    }

    /**
     * Magic get property of DataObject
     *
     * IMPORTANT: For better performance in production you need
     * to make properties public in final DataObjects
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $this->_isPropertyExists($name);

        return $this->$name;
    }

    /**
     * Disallow direct setting of properties
     *
     * @param string $name
     * @param string $value
     *
     * @throws Exception\DirectPropertySetException
     * @deprecated
     */
    public function __set($name, $value)
    {
        throw new DirectPropertySetException($name, $value, $this);
    }

    /**
     * Turning off constructor outside object
     * Use Class::create()
     */
    protected function __construct()
    {}

    /**
     * List of datatypes for properties
     *
     * @return string[]
     */
    protected static function _getDataTypes()
    {
        return [];
    }

    /**
     * Setting for DataObject which set behavior on property changing.
     * If it's false changing of property will generate new DataObject with same values,
     * if it's true changing of property will just change property in object
     *
     * @return bool
     */
    protected static function _isMutable()
    {
        return false;
    }

    /**
     * Exclude validators from serialization
     *
     * @return string[]
     */
    public function __sleep()
    {
        $properties = array_keys(get_object_vars($this));
        unset($properties['validators']);

        return $properties;
    }

    private static function _getPropertyValidator($class, $property)
    {
        $key = sprintf('%s.%s', $class, $property);
        if (!array_key_exists($key, self::$validators)) {
            $types = static::_getDataTypes();
            self::$validators[$key] = array_key_exists($property, $types) ?
                DataObjectValidatorFactory::getValidator($class)->getValidationCallback($types[$property]) :
                null;
        }

        return self::$validators[$key];
    }

    private function _validateDataType($property, $value)
    {
        if (!is_null($value)) {
            $validator = self::_getPropertyValidator(get_class($this), $property);
            if ($validator && !$validator($value)) {
                throw new PropertyValidationFailedException(
                    $property,
                    $value,
                    static::_getDataTypes()[$property],
                    $this
                );
            }
        }
    }

    private function _isPropertyExists($name, $strict = true)
    {
        $result = property_exists($this, $name);
        if ($strict && !$result) {
            throw new PropertyNotFoundException($this, $name);
        }

        return $result;
    }
}
