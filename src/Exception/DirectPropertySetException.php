<?php
namespace Vilks\Data\Exception;

use Vilks\Data\DataObject;

class DirectPropertySetException extends DataObjectException
{
    private $property;
    private $value;

    public function __construct($property, $value, DataObject $data, $message = '', \Exception $previous = null)
    {
        $message = $message ?:
            sprintf(
                'Direct property write access "%s" in DataObject "%s"',
                $property,
                get_class($data)
            );
        parent::__construct($data, $message, $previous);
        $this->property = $property;
        $this->value = $value;
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
}