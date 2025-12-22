<?php

namespace Phrity\Http;

use BadMethodCallException;
use Psr\Http\Message\{
    MessageInterface,
    ResponseInterface,
    RequestInterface,
    UploadedFileInterface,
};

/**
 * Phrity\Http\Serializer
 */
class Serializer
{
    /**
     * @param RequestInterface $request
     */
    public function request(RequestInterface $request): string
    {
        $status = $this->wrap(
            '%s %s HTTP/%s',
            $request->getMethod(),
            $request->getRequestTarget(),
            $request->getProtocolVersion()
        );
        $headers = $this->formatHeaders($request);
        $contents = $request->getBody()->getContents();
        return sprintf("%s%s\r\n%s", $status, $headers, $contents);
    }

    /**
     * @param ResponseInterface $response
     */
    public function response(ResponseInterface $response): string
    {
        $status = $this->wrap(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
        $headers = $this->formatHeaders($response);
        $contents = $response->getBody()->getContents();
        return sprintf("%s%s\r\n%s", $status, $headers, $contents);
    }

    protected function formatHeaders(MessageInterface $message): string
    {
        $lines = '';
        foreach ($message->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                $lines .= $this->wrap('%s: %s', $name, $value);
            }
        }
        return $lines;
    }

    protected function wrap(string $format, string|int ...$values): string
    {
        return trim(sprintf($format, ...$values)) . "\r\n";
    }
}
