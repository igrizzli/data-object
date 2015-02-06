<?php
namespace Vilks\DataObject\Exception;

use Vilks\DataObject\DataObject;

class PropertyNotFoundException extends DataObjectException
{
    private $property;

    public function __construct($property, DataObject $data, $message = '', \Exception $previous = null)
    {
        $message = $message ?:
            sprintf(
                'Property "%s" not found in DataObject "%s"',
                $property,
                get_class($data)
            );
        parent::__construct($data, $message, $previous);
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
}