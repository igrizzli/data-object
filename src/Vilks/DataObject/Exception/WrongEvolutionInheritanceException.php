<?php
namespace Vilks\DataObject\Exception;

use Vilks\DataObject\DataObject;

class WrongEvolutionInheritanceException extends DataObjectException
{
    private $replicaType;

    public function __construct(DataObject $data, DataObject $replicaType, $message = '', \Exception $previous = null)
    {
        $message = $message ?:
            sprintf(
                'DataObject evolution from "%s" to "%s" inheritance error',
                get_class($data),
                get_class($replicaType)
            );
        parent::__construct($data, $message, $previous);
        $this->replicaType = $replicaType;
    }

    /**
     * @return DataObject
     */
    public function getReplicaType()
    {
        return $this->replicaType;
    }
}