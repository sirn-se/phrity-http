<p align="center"><img src="docs/logotype.png" alt="Phrity Http" width="100%"></p>

[![Build Status](https://github.com/sirn-se/phrity-http/actions/workflows/acceptance.yml/badge.svg)](https://github.com/sirn-se/phrity-http/actions)

# Phrity Http

Utilities and interfaces for handling HTTP.

## Installation

Install with [Composer](https://getcomposer.org/);
```
composer require phrity/http
```

## HttpFactory

Convenience wrapper for HTTP factories, where you can add all or any factories to the same class.
The class will then delegate to actual implementation.
If any implementation is missing, a BadMethodCallException will be thrown.

Supports RequestFactoryInterface, ResponseFactoryInterface, ServerRequestFactoryInterface, StreamFactoryInterface, UploadedFileFactoryInterface and UriFactoryInterface from [PSR-17](https://www.php-fig.org/psr/psr-17/).

```php
$factory = new Phrity\Http\HttpFactory(
    requestFactory: $requestFactoryImplementation,
    responseFactory: $responseFactoryImplementation,
    serverRequestFactory: $serverRequestFactoryImplementation,
    streamFactory: $streamFactoryImplementation,
    uploadedFileFactory: $ruploadedFileFactoryImplementation,
    uriFactory: $uriFactoryImplementation,
);
```

Popular PSR-17 implementations, such as [Nyholm](https://packagist.org/packages/nyholm/psr7) and [Guzzle](https://packagist.org/packages/guzzlehttp/psr7), often offer factories that support all interfaces.
By using the `create()` method, the HttpFactory can take any implementation and configure the HttpFactory class with the factories the implementation supports.

```php
$guzzlePsr7 = new GuzzleHttp\Psr7\HttpFactory();
$factory = Phrity\Http\HttpFactory::create($guzzlePsr7);
```

## Serializer

The serializer takes a PSR-7 HTTP Message and converts it to string.
This string representation is a "raw" representation of HTTP request or response.

```php
$serializer = new Serializer();
$request = $serializer->request($psrRequest);
$response = $serializer->response($psrResponse);
$message = $serializer->message($psrMessage);
```

## Versions

| Version | PHP | |
| --- | --- | --- |
| `1.1` | `^8.1` | Serializer; HTTP messages to string representation |
| `1.0` | `^8.1` | HttpFactory convenience wrapper |
