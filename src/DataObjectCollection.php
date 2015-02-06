<?php
namespace Vilks\Data;

class DataObjectCollection
{
    private $type;

    public static function create()
    {

    }

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}