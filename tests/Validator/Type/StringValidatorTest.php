<?php
namespace Vilks\DataObject\Tests\Validator\Type;

use Vilks\DataObject\Validator\Type\StringValidator;

class StringValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCallback()
    {
        $validator = new StringValidator;
        $callback = $validator->getCallback($validator::getName());

        $this->assertFalse($callback(1));
        $this->assertTrue($callback('test'));
        $this->assertFalse($callback(true));
        $this->assertTrue($callback('10'));
    }
}