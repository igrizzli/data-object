<?php
namespace Vilks\DataObject\Tests\Validator\Type;

use Vilks\DataObject\Validator\Type\IntegerValidator;

class IntegerValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCallback()
    {
        $validator = new IntegerValidator;
        $callback = $validator->getCallback($validator::getName());

        $this->assertTrue($callback(10));
        $this->assertTrue($callback(0));
        $this->assertTrue($callback(-1));
        $this->assertFalse($callback(true));
        $this->assertFalse($callback('1test'));
        $this->assertFalse($callback('10'));
    }
}