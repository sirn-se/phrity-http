<?php

namespace Phrity\Http\Test;

use BadMethodCallException;
use Psr\Http\Message\{
    MessageInterface,
    StreamInterface,
};

class BadMessage implements MessageInterface
{
    public function getProtocolVersion(): string
    {
        throw new BadMethodCallException("No.");
    }

    public function withProtocolVersion(string $version): self
    {
        throw new BadMethodCallException("No.");
    }

    public function getHeaders(): array
    {
        throw new BadMethodCallException("No.");
    }

    public function hasHeader(string $name): bool
    {
        throw new BadMethodCallException("No.");
    }

    public function getHeader(string $name): array
    {
        throw new BadMethodCallException("No.");
    }

    public function getHeaderLine(string $name): string
    {
        throw new BadMethodCallException("No.");
    }

    public function withHeader(string $name, mixed $value): self
    {
        throw new BadMethodCallException("No.");
    }

    public function withAddedHeader(string $name, mixed $value): self
    {
        throw new BadMethodCallException("No.");
    }

    public function withoutHeader(string $name): self
    {
        throw new BadMethodCallException("No.");
    }

    public function getBody(): StreamInterface
    {
        throw new BadMethodCallException("No.");
    }

    public function withBody(StreamInterface $body): self
    {
        throw new BadMethodCallException("No.");
    }
}
