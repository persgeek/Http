<?php

namespace PG\Http\Tests;

use PHPUnit\Framework\TestCase;
use PG\Http\Tools\Translator;
use PG\Http\Tools\Convertor;
use PG\Http\Request;

class RequestTest extends TestCase
{
    public function testMergeHeaders()
    {
        $fields = ['token' => 'admin'];

        $translator = new Translator($fields);

        $headers = ['token' => '@token'];

        $request = new Request();

        $data = $request->setTranslator($translator)
            ->setHeaders($headers)
            ->mergeHeaders();

        $this->assertContains('token:admin', $data);
    }

    public function testMergeParams()
    {
        $fields = ['token' => 'admin'];

        $translator = new Translator($fields);

        $algos = ['token' => 'base64'];

        $convertor = new Convertor($algos);

        $params = ['token' => '@token'];

        $request = new Request();

        $data = $request->setTranslator($translator)
            ->setConvertor($convertor)
            ->setParams($params)
            ->mergeParams();

        $this->assertContains('YWRtaW4=', $data);
    }

    public function testBasicAuth()
    {
        $request = new Request();

        $auth = $request->setUsername('saeed')
            ->setPassword('saeed')
            ->getBasicAuth();

        $this->assertSame('saeed:saeed', $auth);
    }
}