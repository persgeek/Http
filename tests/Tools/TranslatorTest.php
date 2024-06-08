<?php

namespace PG\Http\Tests;

use PHPUnit\Framework\TestCase;
use PG\Http\Tools\Translator;
use Exception;

class TranslatorTest extends TestCase
{
    public function testTranslate()
    {
        $fields = ['name' => 'Saeed'];

        $translator = new Translator($fields);

        $content = $translator->translate('Hello @name');

        $this->assertSame($content, 'Hello Saeed');
    }

    public function testReplace()
    {
        $fields = ['name' => 'Saeed'];

        $translator = new Translator($fields);

        $content = $translator->replace('name', 'Saeed', 'Hello @name');

        $this->assertSame($content, 'Hello Saeed');
    }

    public function testEnsureItsNotArray()
    {
        $fields = [
            'fruits' => ['apple', 'orange']
        ];

        $translator = new Translator($fields);

        $this->expectException(Exception::class);

        $translator->translate('@fruits');
    }
}