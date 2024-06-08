<?php

namespace PG\Http\Tests;

use PHPUnit\Framework\TestCase;
use PG\Http\Response;

class ResponseTest extends TestCase
{
    public function testResponseStatus()
    {
        $response = new Response(null, 200);

        $status = $response->getStatus();

        $this->assertSame($status, 200);
    }

    public function testResponseData()
    {
        $data = ['name' => 'Saeed'];

        $response = new Response($data, 200);

        $value = $response->getValue('name');

        $this->assertSame($value, 'Saeed');
    }
}