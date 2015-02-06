<?php
namespace Vilks\Data\Exception;

use Vilks\Data\DataObject;

class DataObjectException extends \Exception
{
    private $data;

    public function __construct(DataObject $data, $message = '', \Exception $previous = null)
    {
        $message = $message ?: sprintf('DataObject "%s" processing error', get_class($data));
        parent::__construct($message, 0, $previous);
        $this->data = $data;
    }

    /**
     * @return DataObject
     */
    public function getData()
    {
        return $this->data;
    }
}