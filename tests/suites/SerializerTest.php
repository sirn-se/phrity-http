<?php

declare(strict_types=1);

namespace Phrity\Http\Test;

use DomainException;
use GuzzleHttp\Psr7\HttpFactory as Guzzle;
use PHPUnit\Framework\TestCase;
use Phrity\Http\Serializer;
use Phrity\Http\Test\BadMessage;
use Psr\Http\Message\{
    RequestFactoryInterface,
    ResponseFactoryInterface,
    ServerRequestFactoryInterface,
    StreamFactoryInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface,
    RequestInterface,
    ResponseInterface,
    ServerRequestInterface,
    StreamInterface,
    UploadedFileInterface,
    UriInterface,
};

class SerializerTest extends TestCase
{
    public function setUp(): void
    {
        error_reporting(-1);
    }

    public function testRequest(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $request = $psr
            ->createRequest('GET', 'http://test.se')
            ->withHeader('Test-Header', 'test header')
            ;
        $expected = "GET / HTTP/1.1\r\nHost: test.se\r\nTest-Header: test header\r\n\r\n";
        $result = $serializer->request($request);
        $this->assertEquals($expected, $result);
    }

    public function testRequestWithBody(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $request = $psr
            ->createRequest('GET', 'http://test.se/test')
            ->withHeader('Test-Header', 'test header')
            ->withBody($psr->createStream('{"a":22}'))
            ;
        $expected = "GET /test HTTP/1.1\r\nHost: test.se\r\nTest-Header: test header\r\n\r\n{\"a\":22}";
        $result = $serializer->request($request);
        $this->assertEquals($expected, $result);
    }

    public function testResponse(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $response = $psr
            ->createResponse(200)
            ->withHeader('Test-Header', 'test header')
            ;
        $expected = "HTTP/1.1 200 OK\r\nTest-Header: test header\r\n\r\n";
        $result = $serializer->response($response);
        $this->assertEquals($expected, $result);
    }

    public function testResponseWithBody(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $response = $psr
            ->createResponse(400)
            ->withHeader('Test-Header', 'test header')
            ->withBody($psr->createStream('{"a":22}'))
            ;
        $expected = "HTTP/1.1 400 Bad Request\r\nTest-Header: test header\r\n\r\n{\"a\":22}";
        $result = $serializer->response($response);
        $this->assertEquals($expected, $result);
    }

    public function testRequestMessage(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $request = $psr
            ->createRequest('GET', 'http://test.se')
            ->withHeader('Test-Header', 'test header')
            ;
        $expected = "GET / HTTP/1.1\r\nHost: test.se\r\nTest-Header: test header\r\n\r\n";
        $result = $serializer->message($request);
        $this->assertEquals($expected, $result);
    }

    public function testResponseMessage(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $response = $psr
            ->createResponse(200)
            ->withHeader('Test-Header', 'test header')
            ;
        $expected = "HTTP/1.1 200 OK\r\nTest-Header: test header\r\n\r\n";
        $result = $serializer->message($response);
        $this->assertEquals($expected, $result);
    }

    public function testBadMessage(): void
    {
        $psr = new Guzzle();
        $serializer = new Serializer();
        $message = new BadMessage();
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Unsupported message type: Phrity\Http\Test\BadMessage');
        $result = $serializer->message($message);
    }
}
