<?php
namespace Vilks\DataObject\Validator;

interface DataObjectValidator
{
    public function getValidationCallback($typeString);
}