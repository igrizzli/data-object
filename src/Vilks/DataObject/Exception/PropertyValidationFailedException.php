<?php
namespace Vilks\DataObject\Exception;

use Vilks\DataObject\DataObject;

class PropertyValidationFailedException extends DataObjectException
{
    private $property;
    private $value;
    private $type;

    public function __construct($property, $value, $type, DataObject $data, $message = '', \Exception $previous = null)
    {
        $message = $message ?:
            sprintf(
                'Data type validation of property "%s" in DataObject "%s" was failed. Expected "%s" but given "%s"',
                $property,
                get_class($data),
                $type,
                print_r($value, true)
            );
        parent::__construct($data, $message, $previous);
        $this->property = $property;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}