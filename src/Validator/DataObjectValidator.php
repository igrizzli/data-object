<?php
namespace Vilks\Data\Validator;

interface DataObjectValidator
{
    public function getValidationCallback($typeString);
}