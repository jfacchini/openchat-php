<?php

namespace App\Tests\RestTestCase;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

class Then
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function statusCode(int $statusCode): self
    {
        Assert::assertSame(
            $statusCode,
            $this->response->getStatusCode(),
            sprintf('Wrong status code. Body: %s', $this->response->getContent()),
        );

        return $this;
    }

    public function contentType(string $type): self
    {
        Assert::assertSame(
            $type,
            $this->response->headers->get('Content-Type'),
            'Wrong content type.',
        );

        return $this;
    }

    public function body(string $key, callable $assert): self
    {
        $body = json_decode($this->response->getContent(), true);

        if (isset($body[$key])) {
            $assert($body[$key]);
        } else {
            Assert::fail("Json body does not contain any '$key' key.");
        }

        return $this;
    }
}
