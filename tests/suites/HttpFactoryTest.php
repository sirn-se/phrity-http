<?php

declare(strict_types=1);

namespace Phrity\Http\Test;

use BadMethodCallException;
use GuzzleHttp\Psr7\HttpFactory as Guzzle;
use PHPUnit\Framework\TestCase;
use Phrity\Http\HttpFactory;
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

class HttpFactoryTest extends TestCase
{
    public function setUp(): void
    {
        error_reporting(-1);
    }

    public function testConstructor(): void
    {
        $psr = new Guzzle();
        $factory = new HttpFactory($psr, $psr, $psr, $psr, $psr, $psr);
        $this->assertInstanceOf(RequestFactoryInterface::class, $factory);
        $this->assertInstanceOf(ResponseFactoryInterface::class, $factory);
        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);
        $this->assertInstanceOf(StreamFactoryInterface::class, $factory);
        $this->assertInstanceOf(UploadedFileFactoryInterface::class, $factory);
        $this->assertInstanceOf(UriFactoryInterface::class, $factory);
        $this->assertInstanceOf(RequestInterface::class, $factory->createRequest('a', 'b'));
        $this->assertInstanceOf(ResponseInterface::class, $factory->createResponse());
        $this->assertInstanceOf(ServerRequestInterface::class, $factory->createServerRequest('GET', 'b'));
        $this->assertInstanceOf(StreamInterface::class, $factory->createStream('a'));
        $this->assertInstanceOf(
            StreamInterface::class,
            $factory->createStreamFromFile(__DIR__ . '/../fixtures/file.txt')
        );
        $this->assertInstanceOf(
            StreamInterface::class,
            $factory->createStreamFromResource($this->file())
        );
        $this->assertInstanceOf(
            UploadedFileInterface::class,
            $factory->createUploadedFile($factory->createStream('a'))
        );
        $this->assertInstanceOf(UriInterface::class, $factory->createUri('b'));
    }

    public function testCreator(): void
    {
        $psr = new Guzzle();
        $factory = HttpFactory::create($psr);
        $this->assertInstanceOf(RequestFactoryInterface::class, $factory);
        $this->assertInstanceOf(ResponseFactoryInterface::class, $factory);
        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);
        $this->assertInstanceOf(StreamFactoryInterface::class, $factory);
        $this->assertInstanceOf(UploadedFileFactoryInterface::class, $factory);
        $this->assertInstanceOf(UriFactoryInterface::class, $factory);
        $this->assertInstanceOf(RequestInterface::class, $factory->createRequest('a', 'b'));
        $this->assertInstanceOf(ResponseInterface::class, $factory->createResponse());
        $this->assertInstanceOf(ServerRequestInterface::class, $factory->createServerRequest('GET', 'b'));
        $this->assertInstanceOf(StreamInterface::class, $factory->createStream('a'));
        $this->assertInstanceOf(
            StreamInterface::class,
            $factory->createStreamFromFile(__DIR__ . '/../fixtures/file.txt')
        );
        $this->assertInstanceOf(
            StreamInterface::class,
            $factory->createStreamFromResource($this->file())
        );
        $this->assertInstanceOf(
            UploadedFileInterface::class,
            $factory->createUploadedFile($factory->createStream('a'))
        );
        $this->assertInstanceOf(UriInterface::class, $factory->createUri('b'));
    }

    public function testNoRequestFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createRequest not implemented.');
        $factory->createRequest('a', 'b');
    }

    public function testNoResponseFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createResponse not implemented.');
        $factory->createResponse();
    }

    public function testNoServerRequestFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createServerRequest not implemented.');
        $factory->createServerRequest('GET', 'b');
    }

    public function testNoStreamFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createStream not implemented.');
        $factory->createStream('a');
    }

    public function testNoStreamFileFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createStreamFromFile not implemented.');
        $factory->createStreamFromFile(__DIR__ . '/../fixtures/file.txt');
    }

    public function testNoStreamFileResource(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createStreamFromResource not implemented.');
        $factory->createStreamFromResource($this->file());
    }

    public function testNoUploadedFileFactory(): void
    {
        $psr = new Guzzle();
        $factory = new HttpFactory(streamFactory: $psr);
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createUploadedFile not implemented.');
        $factory->createUploadedFile($factory->createStream('a'));
    }

    public function testNoUriFactory(): void
    {
        $factory = new HttpFactory();
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('HttpFactory.createUri not implemented.');
        $factory->createUri('b');
    }

    /** @return resource */
    private function file()
    {
        /** @var resource */
        return fopen(__DIR__ . '/../fixtures/file.txt', 'r');
    }
}
