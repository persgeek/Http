<?php

namespace PG\Http\Tests;

use PHPUnit\Framework\TestCase;
use PG\Http\Tools\Convertor;
use Exception;

class ConvertorTest extends TestCase
{
    public function testCanConvertToAlgo()
    {
        $algos = ['name' => 'md5'];

        $convertor = new Convertor($algos);

        $content = $convertor->convert('name', 'Saeed');

        $this->assertSame($content, '3c85276399a8b5302d66067fd5844cd8');
    }

    public function testCanNotConvertToAlgo()
    {
        $algos = ['name' => 'md3'];

        $convertor = new Convertor($algos);

        $this->expectException(Exception::class);

        $convertor->convert('name', 'Saeed');
    }

    public function testCanConvertToCustomAlgo()
    {
        $algos = ['name' => 'base64'];

        $convertor = new Convertor($algos);

        $content = $convertor->convert('name', 'Saeed');

        $this->assertSame($content, 'U2FlZWQ=');
    }

    public function testCanNotConvertToCustomAlgo()
    {
        $algos = ['name' => 'base33'];

        $convertor = new Convertor($algos);

        $this->expectException(Exception::class);

        $convertor->convert('name', 'Saeed');
    }

    public function testCanConvertToBoolean()
    {
        $algos = ['is_active' => 'boolean'];

        $convertor = new Convertor($algos);

        $content = $convertor->convert('is_active', 'yes');

        $this->assertIsBool($content);
    }
}