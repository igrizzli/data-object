<?php
namespace Vilks\Data\Validator;

class DataObjectValidatorFactory
{
    private static $globalValidator;
    private static $classValidators = [];

    /**
     * @param DataObjectValidator $validator
     */
    public static function setGlobalValidator(DataObjectValidator $validator)
    {
        self::$globalValidator = $validator;
    }

    /**
     * @param $class
     * @param DataObjectValidator $validator
     */
    public static function setClassValidator($class, DataObjectValidator $validator = null)
    {
        self::$classValidators[$class] = $validator;
    }

    /**
     * @param string $class
     *
     * @return DataObjectValidator
     */
    public static function getValidator($class = null)
    {
        self::init();
        if (array_key_exists($class, self::$classValidators) && self::$classValidators[$class]) {
            return self::$classValidators[$class];
        }

        return self::$globalValidator;
    }

    private static function init()
    {
        if (!self::$globalValidator) {
            self::$globalValidator = new BaseDataObjectValidator;
        }
    }
}